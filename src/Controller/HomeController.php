<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="home")
     */
    public function index(): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();

        return $this->render('home/index.html.twig', array('home' => $book));
    }
}
