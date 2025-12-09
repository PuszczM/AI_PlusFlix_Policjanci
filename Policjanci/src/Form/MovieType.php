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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Category[] $categories */
        $categories = $options['categories'];
        /** @var Service[] $services */
        $services = $options['services'];

        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => ['maxlength' => MovieDTO::TITLE_SIZE, 'placeholder' => 'Movie title'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['maxlength' => MovieDTO::DESCRIPTION_SIZE, 'placeholder' => 'Movie description...'],
            ])
            ->add('releaseYear', IntegerType::class, [
                'label' => 'Release Year',
                'attr' => ['placeholder' => '2025'],
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'attr' => ['maxlength' => MovieDTO::COUNTRY_SIZE, 'placeholder' => 'Country'],
            ])
            ->add('isSeries', ChoiceType::class, [
                'label' => 'Is this a series?',
                'choices' => ['Yes' => true, 'No' => false],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('posterPath', TextType::class, [
                'label' => 'Poster Path',
                'required' => false,
                'attr' => ['maxlength' => MovieDTO::POSTER_PATH_SIZE, 'placeholder' => '/img/poster.png'],
            ])
            ->add('isAdult', ChoiceType::class, [
                'label' => '18+ Content?',
                'choices' => ['Yes' => true, 'No' => false],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choices' => $categories,
                'choice_label' => 'name',
                'expanded' => true, // checkboxes
                'multiple' => true,
                'label' => 'Categories',
            ])
            ->add('services', EntityType::class, [
                'class' => Service::class,
                'choices' => $services,
                'choice_label' => 'fullName',
                'expanded' => true, // checkboxes
                'multiple' => true,
                'label' => 'Available on',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MovieDTO::class,
            'categories' => [],
            'services' => [],
        ]);

        $resolver->setRequired(['categories', 'services']);
    }
}
