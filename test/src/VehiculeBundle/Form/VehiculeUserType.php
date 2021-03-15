<?php

namespace VehiculeBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


           // ->add('idUser')

            ->add('dateDebut', DateType::class,[
               'widget'=>'single_text',
               'format'=>'yyyy-MM-dd'
           ])
            ->add('dateFin', DateType::class,[
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd'
            ])
            ->add('etat', HiddenType::class, [
                'data' => 'nonfini',
            ])
        ->add('Reserver', SubmitType::class,
        ['attr'=>['formnovalidate'=>'formnovalidate']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculeBundle\Entity\VehiculeUser'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vehiculebundle_vehiculeuser';
    }


}
