<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genres')]
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
    #[Route('/', name: 'genres.index', methods: ['GET'])]
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
    #[Route('/{slug}', name: 'category.index', methods: ['GET'])]
    public function indexI(
        Category $category,
        CategoryRepository $repository, 
        string $slug,
         ): Response
    {   
       $category = $repository->findOneBy(['name'=>$slug]);
        $category->getAnimes()->toArray();

       return $this->render('pages/genre/category.html.twig', [
            'category' => $category

        ]);
        
    }

}
