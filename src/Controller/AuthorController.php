<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Form\MayssaType;
use App\Form\RziguiType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showdbauthor', name: 'showdbauthor')]
    public function showdbauthor(AuthorRepository $authorRepository,Request $req): Response
    {
        $authors=$authorRepository->findAll();
        //$authors=$authorRepository->searchalph();

       /* $form=$this->createForm(RziguiType::class);

        $form->handleRequest($req);
            if ($form->isSubmitted()){
                $min=$form->get('min')->getData();
                $max=$form->get('max')->getData();
            }
            $authors=$authorRepository->minmax($min,$max);
            */


            $authors = $authorRepository->deleteAuthors();

        return $this->render('author/showdbauthor.html.twig', [
            'Author' => $authors,

        ]);
    }

    #[Route('/addformauthor', name: 'addformauthor')]
    public function addformauthor(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $em=$managerRegistry->getManager();
        $author=new Author();
        $form=$this->createForm(AuthorType::class, $author);
        $form->handleRequest($req);
        if($form->isSubmitted() and $form->isValid()) {

            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('showdbauthor');
        }
        return $this->renderForm('author/addformauthor.html.twig', [
            'f'=>$form
        ]);
    
    }

    #[Route('/editauthor/{id}', name: 'editauthor')]
    public function editauthor($id,AuthorRepository $authorRepository,Request $req,ManagerRegistry $managerRegistry): Response
    {
        $em=$managerRegistry->getManager();
        //var_dump($id).die();
        $dataid=$authorRepository->find($id);
        //var_dump($dataid).die();
        $form=$this->createForm(AuthorType::class,$dataid);
        $form->handleRequest($req);

        if($form->isSubmitted() and $form->isValid() ){

            $em->persist($dataid);
            $em->flush();
            return $this->redirectToRoute('showdbauthor');
        }
        return $this->renderForm('author/editauthor.html.twig', [
            'x'=>$form
        ]);
    }

    #[Route('/deleteauthor/{id}', name: 'deleteauthor')]
    public function deleteauthor($id, ManagerRegistry $managerRegistry,AuthorRepository $authorRepository,Request $req): Response
    {
        $em=$managerRegistry->getManager();
        $dataid=$authorRepository->find($id);
        
        $em->remove($dataid);
        $em->flush();

        return $this->redirectToRoute('showdbauthor');
    }

}
