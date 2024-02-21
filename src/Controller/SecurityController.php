<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{   

    /**
     * Ce controller permet à un utilisateur de se connecter
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'security.login', methods:['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * Ce controlleur nous permet de se déconnecter
     *
     * @return void
     */

    #[Route('/deconnexion', name:'security.logout')]
    public function logout() 
    {
        //Nothing to do here..
    }

    /**
     * Ce controller permet d'inscrire un nouvel utilisateur
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/inscription', name: 'security.registration', methods:['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager) : Response
    {   
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

                $this->addFlash(
                'success',
                'Bienvenue ! Ton compte a bien été crée !'
            );
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security.login');
            
        }
        return $this->render('pages/security/registration.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}
