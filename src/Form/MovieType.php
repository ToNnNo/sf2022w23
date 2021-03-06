<?php

namespace App\Form;

use App\Entity\Director;
use App\Entity\Movie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                    'placeholder' => "movie.title.placeholder" // "Indiquez ici le titre du film"
                ],
                'help' => "movie.title.help", // 'Indiquez le nom exact du film',
                'label' => 'movie.title.label',
                // 'constraints' => [ new NotBlank() ]
            ])
            ->add('duration', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('synopsis', null, [
                'attr' => ['rows' => 6]
            ])
            ->add('file', FileType::class, [
                'label' => 'Affiche'
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('director', EntityType::class, [
                'label' => 'Réalisateur',
                'placeholder' => 'Choisissez un Réalisateur',
                'class' => Director::class,
                'choice_label' => function(Director $director) {
                    return $director->getFullname();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->where('d.active = :active')
                        ->setParameter('active', true)
                        ->orderBy('d.lastname', 'asc');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
            'translation_domain' => 'forms',
            'required' => false
        ]);
    }
}
