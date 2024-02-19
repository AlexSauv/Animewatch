<?php

namespace App\Form;

use App\Entity\Anime;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AnimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '1',
                'maxlength' => '50'
                ],
                'label'=>'Nom',
                'label_attr' => [
                    'class' => "form label mt-4"
                ],
                'constraints' => [
                    new Assert\Length(['min' => 1, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('episodes', IntegerType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    ],
                    'label'=>'Episodes',
                    'label_attr' => [
                        'class' => "form label mt-4"
                    ],
                    'constraints' => [
                        new Assert\Positive()
                    ]
                    ])
                    ->add('category', EntityType::class, [
                        'class' => Genre::class,
                        'query_builder' => function (GenreRepository $er)  {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.name', 'ASC');
                        },
                        'label' => 'Genres',
                        'label_attr' => ['class' => 'form-label' ],
                        'choice_label' => 'name',
                        'multiple' => true,
                        
                    ])
            ->add('period', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1978',
                    'max' => '2024'
                    ],
                    'label'=>'Année',
                    'label_attr' => [
                        'class' => "form label mt-4"
                    ],
                    'constraints' => [
                            new Assert\PositiveOrZero()
                    ]
                ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '1',
                    'maxlength' => '50'
                    ],
                    'label'=>'Description',
                    'label_attr' => [
                        'class' => "form label mt-4"
                    ],
                    'constraints' => [
                        new Assert\Length(['min' => 0, 'max' => 250])
                    ]
                ])
            ->add ('submit', SubmitType::class, [
                'attr' => ['class'=> 'btn btn-dark mt-4'],
                'label'=> 'Soumettre mon anime'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Anime::class,
        ]);
    }
}
