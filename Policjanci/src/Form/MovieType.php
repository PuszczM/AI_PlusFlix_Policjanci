<?php

namespace App\Form;

use App\DTO\MovieDTO;
use App\Entity\Category;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Movie title',
                    'maxlength' => MovieDTO::TITLE_SIZE,
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Description...',
                    'maxlength' => MovieDto::DESCRIPTION_SIZE,
                ],
            ])
            ->add('releaseYear', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Release year',
                ],
            ])
            ->add('country', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Country',
                    'maxlength' => MovieDTO::COUNTRY_SIZE,
                ],
            ])
            ->add('isSeries', CheckboxType::class, [
                'label' => 'Is it a series?',
                'required' => false,
            ])
            ->add('posterPath', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Poster path (optional)',
                    'maxlength' => MovieDTO::POSTER_PATH_SIZE,
                ],
            ])
            ->add('isAdult', CheckboxType::class, [
                'label' => '18+ content',
                'required' => false,
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'label' => 'Categories',
            ])

            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'fullName',
                'expanded' => true,
                'multiple' => true,
                'label' => 'Available on',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MovieDTO::class,
        ]);
    }
}
