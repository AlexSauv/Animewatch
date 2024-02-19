<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GenreController extends AbstractController
{
    /**
     * Ce controller affiche tous les gens
     *
     * @param PaginatorInterface $paginator
     * @param GenreRepository $repository
     * @param Request $request
     * @return Response
     */
    #[Route('/genre', name: 'genre.index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, GenreRepository $repository, Request $request): Response
    {   
        $genres = $paginator->paginate( 
            $repository->findAll(),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('pages/genre/index.html.twig', [
            'genres'=> $genres
        ]);
    }
}
