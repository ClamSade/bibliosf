<?php

namespace App\Form;

use App\Entity\Abonne;
use App\Entity\Emprunt;
use App\Entity\Livre;
// use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_emprunt', DateType::class, [
                'widget'    =>  'single_text',
                'data'      =>  new \DateTime()
            ])
            ->add('date_prevue', DateType::class, [
                'widget'    =>  'single_text'
                ])
            ->add('date_retour', DateType::class, [
                'widget'    =>  'single_text'
                ])
            ->add('livre', EntityType::class, [
                'class' =>  Livre::class,
                'choice_label'  =>  'titre',
                'placeholder'   =>  'Choisir le livre à emprunter'
            ])
            ->add('abonne', EntityType::class, [
                'class' =>  Abonne::class,
                'choice_label'  =>  'pseudo',
                'label' => 'Abonné',
                'placeholder'   =>  ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
