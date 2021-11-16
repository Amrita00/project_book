<?php

namespace App\Controller;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class APIController extends AbstractController
{
    const URL = "https://api.nytimes.com/";
    const KEY = "dgkTFeToaGT0EltPrDWxXlpZzAFAng1D";
    /**
     * @Route("/api", name="api")
     * @throws GuzzleException
     */
    public function index(): Response
    {
        // Create a client with a base URI
        $client = new Client([
            'base_uri' => self::URL,
        ]);

        $headers = [
            'Authorization' => 'Bearer',
            'Accept'        => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'svc/books/v3/lists/names.json?api-key=' . self::KEY,
            [
                'headers' => $headers
            ]
        )->getBody()->getContents();
        $response = json_decode($response);


        return $this->render('api/index.html.twig', [
            'api' => $response,
        ]);
    }
}
