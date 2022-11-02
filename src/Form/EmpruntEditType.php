<?php

namespace App\Form;

use App\Entity\Abonne;
use App\Entity\Emprunt;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_emprunt', DateType::class, [
                'widget'        =>  'single_text',
                'empty_data'    =>  new \DateTime(),
                'attr'          =>  ['readonly' =>  'readonly']

            ])
            ->add('date_prevue', DateType::class, [
                'widget'    =>  'single_text',
                'attr'      =>  ['readonly' =>  'readonly']
            ])
            ->add('date_retour', DateType::class, [
                'widget'    =>  'single_text',
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
