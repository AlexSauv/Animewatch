<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom / Prénom',
                'label_attr'=> [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 2, 'max'=> 50])
                ],
                'invalid_message' => 'Ce champs ne doit pas être vide et remplir les conditions'
            ])
            ->add('pseudo', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'required' => false,
                'label' => 'Pseudo (Facultatif)',
                'label_attr'=> [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\Length(['min'=> 2, 'max'=> 50])
                ],
                'invalid_message' => 'Le pseudo n\'est pas valide.. essayez autre chose !'
            ])

            ->add('email', EmailType::class, [
                'attr'=> [
                    'class'=> 'form-control',
                    'minlength' => '1',
                    'maxlength' => '180'
                ],
                'label' => 'Email',
                'label_attr'=> [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 1, 'max'=> 180])
                ],
                'invalid_message' => 'L\'Email n\'est pas valide..'
            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe',
                'attr'=> [
                    'class'=> 'form-control']],
                'second_options' => ['label' => 'Confirmation du mot de passe',
                'attr'=> [
                    'class'=> 'form-control']],
                    'invalid_message' => 'Les mots de passe ne correspondent pas.'
                    
            ])

            ->add('submit', SubmitType:: class, [
                'attr' =>[
                    'class' => 'btn btn-dark mt-4'
                ],
                'label' => 'S\'inscrire'
            ]) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
