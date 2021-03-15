<?php

namespace VehiculeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('matricule')
            ->add('type',  ChoiceType::class, [
                'placeholder' => 'Type ..',
                'choices' => [
                    'CUV' => 'CUV',
                    'PICKUP' => 'PICKUP',
                    'CAMPERVAN' => 'CAMPERVAN',
                    'MINI TRUCK' => 'MINI TRUCK',
                    'TRUCK' => 'TRUCK' ,
                    'BIG TRUCK' =>'BIG TRUCK',
                ],

            ])
            ->add('puissance', ChoiceType::class, [
                'placeholder' => 'Puissance ..',
                'choices' => [
                    '4 CHEVEAUX' => '4 CHEVEAUX',
                    '5 CHEVEAUX' => '5 CHEVEAUX',
                ],
            ])
            ->add('marque')
            ->add('kilometrage', IntegerType::class)
            ->add('nbplace',IntegerType::class)
            ->add('prix',IntegerType::class)
           ->add('file')
            ->add('etat', HiddenType::class, [
            'data' => 'disponible',
                ])
            ->add('couleur', ColorType::class)

        ->add('Ajouter', SubmitType::class,
      ['attr'=>['formnovalidate'=>'formnovalidate']]
            )

      ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculeBundle\Entity\Vehicule'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vehiculebundle_vehicule';
    }


}
