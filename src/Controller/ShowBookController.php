<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Form\BookType;
use App\Form\EditBookType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function showAdmin(int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);


        return $this->render('show_book/view_details.html.twig', [
            'view' => $book,

        ]);
    }

    /**
     * @Route("/index/view/book/{id}", name="viewbook", methods={"GET"})
     */
    public function showUser(int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);


        return $this->render('show_book/User_viewdetails.html.twig', [
            'view' => $book,

        ]);
    }

    /**
     * @Route("home/edit/book/{id}", name="edit_book", methods={"GET", "POST"} )
     */
    public function edit( Request $request,int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);

        $form = $this->createForm(EditBookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $book->getImage();

            $imageName =md5(uniqid()).'.'.$image->guessExtension();
            try{
                $image->move(
                    $this->getParameter('image_directory'),
                    $imageName
                );
            }catch (FileException $e){
                //TODO
            }
            $book->setImage($imageName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Book Edited!');
            header("refresh:2;url=/home/show/book");

//            return $this->redirectToRoute('show_book');
        }
        return $this->render('show_book/edit_book.html.twig', [
            // 'edit' => $book,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("search/book", name="search_book", methods={"GET", "POST"} )
     */
    public function search(Request $request): JsonResponse
    {
        $searchtitle = $request->get('value');
        $em = $this->getDoctrine()->getManager();
        $search = $em->getRepository(Book::class)->findByTitle($searchtitle);

        $result = $search->getResult();

        $data = $this->renderView('partials/list.html.twig', [
            'home' => $result
        ]);

        return new JsonResponse([
            'searchBook' => $data
        ]);
    }



}
