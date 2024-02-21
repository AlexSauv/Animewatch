<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
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
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min'=> 2, 'max'=> 50])
            ],
            'invalid_message' => 'Le pseudo n\'est pas valide.. essayez autre chose !'
        ])

        ->add('plainPassword', PasswordType::class, [
            'attr'=> [
                'class' => 'form-control'
            ],
            'label' => 'Mot de passe',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])
        ->add('submit', SubmitType:: class, [
            'attr' =>[
                'class' => 'btn btn-danger mt-4'
            ],
            'label' => 'Modifier'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
