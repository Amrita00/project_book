<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddBookController extends AbstractController
{
    /**
     * @Route("home/add/book", name="add_book")
     */
    public function add(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
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

            return $this->redirectToRoute('show_book');
        }
        return $this->render('add_book/index.html.twig', [

            'add_book' => $form->createView(),
        ]);
    }
}
