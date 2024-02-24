<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\WatchList;
use App\Repository\AnimeRepository;
use App\Repository\WatchListRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyHomeController extends AbstractController
{
    #[Route('/myHome', name: 'myhome.index')]

        public function index(PaginatorInterface $paginator, AnimeRepository $repository, WatchListRepository $watchListRepository, WatchList $watchList, Request $request): Response
        {  
            $animes = $repository->findAnimes($request->query->getInt('page', 1));
           
                $watchListRepository->findBy(['user'=> $this->getUser()]);
                
                
            
        return $this->render('pages/myhome/myHome.html.twig', [
                'watchList' => $watchList,
                'animes'=> $animes
            ]);
       
    }
}
