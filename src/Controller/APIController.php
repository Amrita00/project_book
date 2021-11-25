<?php

namespace App\Controller;

use App\Services\NewsService;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class APIController extends AbstractController
{

    /**
     * @Route("/api/search", name="api_search")
     * @throws GuzzleException
     */
    public function apiSearch(Request $request, NewsService $newdetails): Response
    {
        $searchtitle = $request->get('sapi');

        if(!$searchtitle){
            return $this->render('api/index.html.twig', [
                'api2' => [],
            ]);
        } else {
            $response = $newdetails->getNews($searchtitle);
            return $this->render('partials/api.html.twig', [
                'api2' => $response,
            ]);
        }
    }




}
