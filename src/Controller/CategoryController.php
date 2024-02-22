<?php

namespace App\Controller;

use App\Repository\CategoryRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    /**
     * Ce controller affiche tous les gens
     *
     * @param PaginatorInterface $paginator
     * @param CategoryRepository $repository
     * @param Request $request
     * @return Response
     */
    #[Route('/genre', name: 'genre.index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, CategoryRepository $categoryRepository, Request $request): Response
    {   
        $categories = $paginator->paginate( 
            $categoryRepository->findAll(),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('pages/genre/index.html.twig', [
            'Categories'=> $categories
        ]);
    }
}
