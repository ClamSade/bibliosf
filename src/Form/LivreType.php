<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('couverture')
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
