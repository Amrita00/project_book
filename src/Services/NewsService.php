<?php

namespace App\Services;

use App\Entity\NewsApi;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Util\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class NewsService
{
    const URL = "https://newsapi.org/";
    const KEY = "aa4b397490fc4ce2b8be08d77333cedd";
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;


    /**
     * @param EntityManagerInterface $entityManager
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface  $parameterBag
    )
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @throws GuzzleException
     */
    public function getNews($searchtitle)
    {
        $client = new Client([
            'base_uri' => self::URL,
        ]);

        $headers = [
            'Authorization' => 'Bearer',
            'Accept' => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'v2/everything?q=' . $searchtitle . '&apiKey=' . self::KEY,
            [
                'headers' => $headers
            ]
        )->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * @throws GuzzleException
     */
    public function getLatestNews()
    {
        $client = new Client([
            'base_uri' => self::URL,
        ]);

        $headers = [
            'Authorization' => 'Bearer',
            'Accept' => 'application/json',
        ];
        $response = $client->request(
            'GET',

            'v2/top-headlines?apiKey=' . self::KEY . '&sortBy=publishedAt&country=us',
            [
                'headers' => $headers
            ]
        )->getBody()->getContents();

        return json_decode($response, true); // json_decode convert json response into array whereas json encode convert array into json
    }

    /**
     * @throws GuzzleException
     */
    public function processNews($output)
    {
        $news = $this->fetchNewsDetails();

        /*for each article found in news,if the api response object title and description is null then it will continue to the next iteration */
        foreach ($news['articles'] as $article) {

            if (
                empty($article['title']) &&
                empty($article['url']) &&
                empty($article['description']) &&
                empty($article['author'])
            ) {
                continue;
            }

            $url = $article['url'];
            /* to check if url of the api response exist. $article['url] is written like this because the object url is found in array of article */
            if ($this->checkNewsExists($url)) {
                $output->writeln([
                    '<comment>News in database detected, exiting</comment>',
                ]);
                $this->updateNews($article);
                $output->writeln([
                    '<info>News updated</info>',
                ]);

            } else {

                $output->writeln([
                    'News Details fetched, saving into database'
                ]);

                $this->saveNews($article);

                $output->writeln([
                    'News saved'
                ]);
            }

        }
    }

    /**
     * @return array|false
     * @throws GuzzleException
     */
    public function fetchNewsDetails()
    {
        try {
            return $this
                ->getLatestNews();
        } catch (\Exception $exception) {
            throw new Exception('News Details fetched from api failed, exit command');
        }
    }

    public function checkNewsExists($url): bool
    {
        return !empty(
        $this
            ->entityManager
            ->getRepository(NewsApi::class)
            ->findbyLink($url)

        );
    }

    public function saveImage($news): string
    {
        $imageName = uniqid() . '.jpg';
        if (empty($news['urlToImage'])) {
            return 'empty.png';
        } else {
            $content = file_get_contents($news['urlToImage']);
            $fp = fopen(
                $this->parameterBag->get('kernel.project_dir') . "/public/images/" . $imageName,
                "w"
            );
            fwrite($fp, $content);
            fclose($fp);
            return $imageName;
        }

    }

    public function updateNews($article)
    {

        $result = $this
            ->entityManager
            ->getRepository(NewsApi::class)
            ->findbyLink($article['url']);

        $result->setAuthor($article['author'] ?? '');
        $result->setTitle($article['title'] ?? '');
        $result->setDescription($article['description'] ?? ''); // if the description is empty, '' will be inserted in the database.
        $result->setUrl($article['url'] ?? '');

        $image = $this->saveImage($article);
        $result->setUrlToImage($image);

        $date = \DateTime::createFromFormat(
            'Y-m-d h:i:s',
            date('Y-m-d h:i:s', strtotime($article['publishedAt']))
        );

        $result->setPublishedAt($date ?? '');

        $this->entityManager->persist($result);
        $this->entityManager->flush();

    }

    /**
     * @param $news
     */
    public function saveNews($news)
    {

        $info = new NewsApi();
        $info->setAuthor($news['author'] ?? '');
        $info->setTitle($news['title'] ?? '');
        $info->setDescription($news['description'] ?? ''); // if the description is empty, '' will be inserted in the database.
        $info->setUrl($news['url'] ?? '');

        $image = $this->saveImage($news);
        $info->setUrlToImage($image);

        $date = \DateTime::createFromFormat(
            'Y-m-d h:i:s',
            date('Y-m-d h:i:s', strtotime($news['publishedAt']))
        );

        $info->setPublishedAt($date ?? '');

        $this->entityManager->persist($info);
        $this->entityManager->flush();
    }


}