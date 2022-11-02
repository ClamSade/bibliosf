<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('couverture', FileType::class, [
                'mapped'        =>  false,
                'constraints'   =>  [
                    new File([
                        'maxSize'           =>  '2048k',
                        'maxSizeMessage'    =>  'Le fichier ne peut pas peser plus de 2 Mo',
                        'mimeTypes'         =>  ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage'  =>  'Les types de fichiers autorisés sont jpeg, png et gif'
                    ])
                ]
            ])
            ->add('auteur', EntityType::class, [
                'class'         =>  Auteur::class,
                'choice_label'  =>  function($auteur){
                    return $auteur->getPrenom() . " " . $auteur->getNom();
                },
                'placeholder'   =>  'Choisissez un auteur...',
            ])
            ->add('categories', EntityType::class, [
                'class'         =>  Categorie::class,
                'choice_label'  =>  'libelle',
                'multiple'      =>  true,
                'expanded'      =>  true,
                'label'         =>  'Categories',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
