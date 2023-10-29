<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\MayssaType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/showbook', name: 'showbook')]
    public function showbook(BookRepository $bookRepository,Request $req): Response
    {
        /*$form=$this->createForm(MayssaType::class);
        $form->handleRequest($req);
        $books = [];*/

         
        //$books=$bookRepository->findByBooksSorting();
       
        //$books = $bookRepository->findBooks_2023();

         // $books=$bookRepository->findAll();
         

        /*if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $ref = $data['ref'];
            $books = $bookRepository->searchref($ref); 
        }*/


        //$books = $bookRepository->updateWilliam();

        /*if ($boooks) {
            return $this->redirectToRoute('showbook');
        } else {
            $this->addFlash('error', 'Auteur "William Shakespeare" non trouvé.');
        }*/

        //$books = $bookRepository->SumBooks();






        return $this->render('book/showbook.html.twig', [
            //'f' => $form->createView(),
            'book'=>$books
        ]);
    }

    #[Route('/addbook', name: 'addbook')]
    public function addbook(ManagerRegistry $managerRegistry, Request $req): Response
{
    $em= $managerRegistry->getManager();
    $book=new Book();
    $form=$this->createForm(BookType::class,$book);
    $form->handleRequest($req);
    
    if($form->isSubmitted() and $form->isValid()) {
        
        $em->persist($book);
        $em->flush();
       
    }

    {
        return $this->renderForm('Book/addbook.html.twig', [
            'f'=>$form
        ]);
    }
}

#[Route('/editbook/{ref}', name: 'editbook')]
public function editbook($ref , ManagerRegistry $managerRegistry, Request $req, BookRepository $bookRepository): Response
{
$em= $managerRegistry->getManager();
$book=$bookRepository->find($ref);
$form=$this->createForm(BookType::class,$book);
$form->handleRequest($req);

if($form->isSubmitted() and $form->isValid()) {
    
    $em->persist($book);
    $em->flush();
   
}

{
    return $this->renderForm('Book/addbook.html.twig', [
        'f'=>$form
    ]);
}
}

#[Route('/deletbook/{ref}', name: 'deletbook')]
public function deletbook($ref,ManagerRegistry $managerRegistry,BookRepository $bookRepository , Request $req): Response
{
    $em=$managerRegistry->getManager();
        $dataid=$bookRepository->find($ref);
        
        $em->remove($dataid);
        $em->flush();

        return $this->redirectToRoute('showbook');
}




}
