<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Form\BookEditType;
use App\Form\BookType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowBookController extends AbstractController
{
    /**
     * @Route("home/show/book", name="show_book")
     */
    public function index(): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();

        return $this->render('show_book/index.html.twig', array('book' => $book));
    }

    /**
     * @Route("/home/view/book/{id}", name="view_book", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);


        return $this->render('show_book/view_details.html.twig', [
            'view' => $book,

        ]);
    }

    /**
     * @Route("home/edit/book/{id}", name="edit_book", methods={"GET", "POST"} )
     */
    public function edit( Request $request,int $id): Response
    {

        // $book = new Book();
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);


        $form = $this->createForm(BookEditType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('show_book');
        }
        return $this->render('show_book/edit_book.html.twig', [
            // 'edit' => $book,
            'form' => $form->createView(),
        ]);
    }

}
