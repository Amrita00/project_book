<?php

namespace App\Controller;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class APIController extends AbstractController
{
    const URL = "https://api.nytimes.com/";
    const KEY = "aa4b397490fc4ce2b8be08d77333cedd";
    /**
     * @Route("/api/search", name="api_search")
     * @throws GuzzleException
     */
    public function apiSearch(Request $request): Response
    {
//        $searchtitle = $request->get('sapi');
        $searchtitle = "us";
        // Create a client with a base URI
        $client = new Client([
            'base_uri' => 'https://newsapi.org/' ,
        ]);

        $headers = [
            'Authorization' => 'Bearer',
            'Accept' => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'v2/top-headlines?country='.$searchtitle.'&apiKey='.self::KEY,
            [
                'headers' => $headers
            ]
        )->getBody()->getContents();
        $response = json_decode($response);


        return $this->render('api/index.html.twig', [
            'api2' => $response,
        ]);
    }


//    /**
//     * @Route("/api", name="api_display")
//     * @throws GuzzleException
//     */
//    public function apiDisplay(): Response
//    {
//        // Create a client with a base URI
//        $client = new Client([
//            'base_uri' => self::URL,
//        ]);
//
//        $headers = [
//            'Authorization' => 'Bearer',
//            'Accept' => 'application/json',
//        ];
//        $response = $client->request(
//            'GET',
//            'svc/books/v3/lists/names.json?api-key=' . self::KEY,
//            [
//                'headers' => $headers
//            ]
//        )->getBody()->getContents();
//        $response = json_decode($response);
//
//
//        return $this->render('api/index.html.twig', [
//            'api' => $response,
//        ]);
//    }


}
