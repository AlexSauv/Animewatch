<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\User;
use App\Entity\WatchList;
use App\Repository\WatchListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MyHomeController extends AbstractController
{   
    
    #[Route('/myHome', name: 'myhome.index', methods : ['GET'])]
    
        public function index( Anime $anime,  WatchListRepository $watchListRepository,  WatchList $watchList,User $user, ): Response
        {   
            
            $watchList = $watchListRepository->findOneBy(['user' => $this->getUser()]);
            $watchList->getAnime()->toArray();

        
           
             return $this->render('pages/myhome/myHome.html.twig', [
                'watchList' => $watchList, 
                'anime' => $anime,
                
                'user' => $user,
                
            
            ]);
             
       }

    

       #[Route('/myhome/add/{id}', name: 'watchList.add')]

       public function add($id, Request $request){
        $session = $request->getSession();

        $watchList = $session->get('watchList', []);

        $watchList[$id] = 1;

        $session->set('watchList', $watchList);

        dd($session->get('watchList'));



       }
}

