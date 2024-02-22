<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnimeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyHomeController extends AbstractController
{
    #[Route('/myHome', name: 'myhome.index')]

        public function index(PaginatorInterface $paginator, AnimeRepository $repository, Request $request): Response
        {  

            $animes = $paginator->paginate( 
                $repository->findBy(['user'=> $this->getUser()]),
                $request->query->getInt('page', 1),
                20
            );
        return $this->render('pages/myhome/myHome.html.twig', [
                'animes'=> $animes
            ]);
       
    }
}
