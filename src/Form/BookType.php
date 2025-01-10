<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du livre',
                'attr' => ['class' => 'form-input', 'aria-label' => 'Nom du livre'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'textarea', 'placeholder' => "Notez ici les idées importantes de l'œuvre.", 'aria-label' => 'Description'],
            ])
            ->add('rating', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '1.5' => 1.5,
                    '2' => 2,
                    '2.5' => 2.5,
                    '3' => 3,
                    '3.5' => 3.5,
                    '4' => 4,
                    '4.5' => 4.5,
                    '5' => 5,
                ],
                'label' => 'Note',
                'attr' => ['class' => 'form-input', 'aria-label' => 'Note'],
                'placeholder' => 'Sélectionnez une note',
            ])

            ->add('completed', CheckboxType::class, [
                'label' => 'Lecture terminée',
                'required' => false,
                'attr' => ['class' => 'form-checkbox', 'aria-label' => 'Lecture terminée'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
