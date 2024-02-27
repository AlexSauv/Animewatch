<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Entity\Note;
use App\Form\AnimeType;
use App\Form\NoteType;
use App\Repository\AnimeRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimeController extends AbstractController
{   
    
    /**
     * Ce controller affiche tous les animes
     *
     * @param AnimeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/anime', name: 'anime.index', methods: ['GET'])]
    public function index(AnimeRepository $repository, Request $request): Response
    {   
        $animes = $repository->findAnimes($request->query->getInt('page', 1));
        return $this->render('pages/anime/index.html.twig', [
            'animes'=> $animes
        ]);
    }
    /**
     * Ce controller permet d'ajour un animé à la liste
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */ 

    #[Route('/anime/new', name:'anime.new', methods: ['GET', 'POST'])]
    public function new(Request $request, 
    EntityManagerInterface $manager
    ): Response
    {   
        $anime = new Anime();
        $form = $this->createForm(AnimeType::class, $anime);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $anime = $form->getData();
            
            $manager->persist($anime);
            $manager->flush();

            $this->addFlash(
                'success',
                'Félicitation ! Ton anime a bien été enregistré!'
            );
            return $this->redirectToRoute('anime.index');
        }
        return $this->render('pages/anime/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    /**
     * Ce controlleur permet de modifier un Anime
     */
    #[Route('/anime/edit/{id}', name:'anime.edit', methods:['GET', 'POST'])]
    public function edit( Anime $anime, Request $request, EntityManagerInterface $manager) : Response
    {   
        $form = $this->createForm(AnimeType::class, $anime);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $anime = $form->getData();
            
            $manager->persist($anime);
            $manager->flush();

            $this->addFlash(
                'success',
                'Félicitation ! La modification de ton anime a bien été enregistré!'
            );
            return $this->redirectToRoute('anime.index');
        }

        return $this->render('/pages/anime/edit.html.twig', [
           'form' => $form->createView()
        ]);
    }

    #[Route('/anime/delete/{id}', name:'anime.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, Anime $anime): Response
    {
        $manager->remove($anime);
        $manager->flush();

        $this->addFlash(
            'success',
            'La suppression de ton animé a bien été enregistrée!'
        );

        return $this->redirectToRoute('anime.index');       
    }

    /*** A REVOIR VITE !!!!!!!!!!!! Ne met pas le top !! 
     * 
    */
    #[Route('/anime/tendance', name: 'anime_top.index', methods: ['GET'])]
    public function topTendance(AnimeRepository $repository, Request $request): Response
    {   
        $animes = $repository->findAnimes($request->query->getInt('page', 1));
        return $this->render('pages/anime/tendance.html.twig', [
            'animes'=> $animes
        ]);

    }

    #[Route('anime/{slug}', name: 'anime_name.index', methods: ['GET', 'POST'])]
    public function indexI(
        Anime $anime,
        AnimeRepository $repository, 
        string $slug, Request $request, NoteRepository $noteRepository, EntityManagerInterface $manager
         ): Response
    {   
       $anime = $repository->findOneBy(['name'=>$slug]);

         
        $note = new Note(); 
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $note->setUser($this->getUser())
            ->setAnime($anime);

            $existingNote = $noteRepository->findOneBy(['user'=>$this->getUser(), 'anime' => $anime]);

            if(!$existingNote) {
                $manager->persist($note);
            } else {
                $existingNote->setNote(
                 $form->getData()->getNote());
            
            }
            $manager->flush();

            $this->addFlash(
                'success',
                'Ta note à bien été enregistrée :)'
            );

            return $this->redirectToRoute('anime_name.index', ['slug'=>$anime->getName()]);
        }

       return $this->render('pages/anime/show.html.twig', [
            'anime' => $anime,
            'form' => $form->createView()
        ]);
        
    }

}