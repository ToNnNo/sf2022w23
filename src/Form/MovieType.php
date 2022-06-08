<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    // 'class' => 'form-control',
                    'placeholder' => "Indiquez ici le titre du film"
                ],
                'help' => 'Indiquez le nom exact du film',
                'label' => 'Titre',
                // 'constraints' => [ new NotBlank() ]
            ])
            ->add('duration', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('synopsis', null, [
                'attr' => ['rows' => 6]
            ])
            // ->add('poster', FileType::class)
            ->add('releaseDate', DateType::class, [
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
            'required' => false
        ]);
    }
}
