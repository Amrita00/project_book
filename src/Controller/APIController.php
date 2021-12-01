<?php

namespace App\Controller;

use App\Entity\NewsApi;
use App\Services\NewsService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class APIController extends AbstractController
{

    /**
     * @Route("/api/search", name="api_searchnews")
     * @throws GuzzleException
     */
    public function apiSearch(Request $request, NewsService $newdetails): Response
    {
        $searchtitle = $request->get('sapi');

        if (!$searchtitle) {
            return $this->render('api/index.html.twig', [
                'api2' => [],
            ]);
        } else {
            $response = $newdetails->getNews($searchtitle);
            return $this->render('partials/api_viewlist.html.twig', [
                'api2' => $response,
            ]);
        }
    }

    /**
     * @Route("/api/view", name="api_viewnews")
     * @throws Exception|GuzzleException
     */
    public function getLatestNews(NewsService $newsService): Response
    {
        try {
           $newsService->processNews();

        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
            return $this->render('api/view_latestnews.html.twig', [
                'news' => []
            ]);
        }
        $news = $this->getDoctrine()
            ->getRepository(NewsApi::class)
            ->findBy([],['publishedAt' => 'DESC']);
        return $this->render('api/view_latestnews.html.twig', [
            'news' => $news
        ]);

    }


}
