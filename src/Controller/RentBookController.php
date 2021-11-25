<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\RentBook;
use App\Form\RentBookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RentBookController extends AbstractController
{
    /**
     * @Route("/rent/book/{id}", name="rent_book", methods={"GET", "POST"})
     */
    public function getRentBook(Request $request): Response
    {
        $id = $request->get('id');
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        $rent = new RentBook();
        $form = $this->createForm(RentBookType::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $this->getUser();
            $rent->setUser($user);
            $rent->setBook($book);
            $em->persist($rent);
            $em->flush();

            $this->addFlash('success', 'Movie Rented Successfully!');
            header("refresh:2;url=/index/user");
        }

        return $this->render('rent_book/index.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }
}
