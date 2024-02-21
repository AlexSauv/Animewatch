<?php

namespace App\Controller;

use App\Entity\User;
use App\EntityListener\UserListener;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{   
    /**
     * Ce controller permet à l'utiliseur de modifier son nom et son pseudo
     * Les autres individu seront redirigé sur une autre page
     */
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(User $user,Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()) 
        {
            return $this->redirectToRoute('security.login');
        }


        if ($this->getUser() !== $user) 
        {
            return $this->redirectToRoute('Home.index');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
        if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())){
            $user = $form->getData(); 
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Vos modifications ont bien été prise en compte !'
            );
                return $this->redirectToRoute('anime.index');
            } else {
            $this->addFlash(
                'danger',
                'Le mot passe est incorrect.'
            );
        } 
    }

        return $this->render('pages/user/edit.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    /**
     * Permet de changer le mot de passe 
     * ATTENTION !!! Tu dois modifier les flashs DANGER
     */
    #[Route('/utilisateur/edition-mot-de-passe/{id}', name:'user.edit.password', methods:['GET', 'POST'])]
    public function editPassword(User $user, Request $request,EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response 
    {   
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form-> isValid()) {
            if($hasher->isPasswordValid($user, $form->getData()['plainPassword']))
            {
                $user->setPassword( 
                    $hasher->hashPassword($user,
                    $form->getData()['newPassword'])
                    );
                
                $manager->persist($user);
                $manager->flush();
                

                $this->addFlash(
                    'success',
                    'Votre mot de passe a bien été changé.');
                    return $this->redirectToRoute('anime.index');
            } else {
                $this->addFlash(
                    'danger',
                    'Le mot passe est incorrect.'
                );
            }
        }    
        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);   
    }
}