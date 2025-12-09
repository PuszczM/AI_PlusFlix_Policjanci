<?php
namespace App\Form;

use App\DTO\PostReviewDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Username', 'maxlength' => PostReviewDTO::AUTHOR_SIZE],
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Comment text...', 'maxlength' => PostReviewDTO::COMMENT_SIZE],
            ])
            ->add('positive', ChoiceType::class, [
                'label' => 'Did you like it?',
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostReviewDTO::class,
        ]);
    }
}
