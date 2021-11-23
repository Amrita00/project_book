<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentBookController extends AbstractController
{
    /**
     * @Route("/rent/book", name="rent_book")
     */
    public function index(): Response
    {
        return $this->render('rent_book/index.html.twig', [
            'controller_name' => 'RentBookController',
        ]);
    }
}
