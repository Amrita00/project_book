<?php

namespace App\Command;

use App\Entity\NewsApi;
use App\Services\NewsService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class NewsSynchCommand extends Command
{
    /**
     * @var NewsService
     */
    private NewsService $newsService;


    /**
     * @var string
     */
    protected static $defaultName = 'app:news-sync';

    /**
     * @var string
     */
    protected static $defaultDescription = 'To synchronise news';

    /**
     * @param NewsService $newsService
     * @param string|null $name
     */
    public function __construct(
        NewsService $newsService,
        string      $name = null
    )
    {
        $this->newsService = $newsService;
        parent::__construct($name);
    }

    protected function configure(): void
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            '<info>News detected</info>',
            'Fetch News details from API in progress'
        ]);

        try {
            $news = $this->newsService->fetchNewsDetails($output);


            /*for each article found in news,if the api response object title and description is null then it will continue to the next iteration */
            foreach ($news['articles'] as $article) {

                if (empty($article['title']) && empty($article['description']) && empty($article['author'])) {
                    continue;
                }


                $url = $article['url'];
                /* to check if url of the api response exist. $article['url] is written like this because the object url is found in array of article */
                if ($this->newsService->checkNewsExists($url)) {
                    $this->newsService->updateNews($article, $output);
                    $output->writeln([
                        '<comment>News in database detected, exiting</comment>',
                    ]);
                    continue; // continues with the next iteration in the if loop.
                }

                $output->writeln([
                    'News Details fetched, saving into database'
                ]);

                $this->newsService->saveNews($article);

                $output->writeln([
                    'News saved'
                ]);
            }
        } catch (\Exception $exception) {
            $output->writeln([
                "<comment>{$exception->getMessage()}</comment>",
            ]);
        }

        return true;
    }

}
