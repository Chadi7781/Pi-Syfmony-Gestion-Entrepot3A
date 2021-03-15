<?php

namespace ServiceApresVenteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RecFeedCatType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',ChoiceType::class, [
            'choices'  => [
                'Retard Transport' => 'Retard Transport',
                'Produit Manquant' => 'Produit Manquant',
                'Commande' => 'Commande'],
                ])
        ->add('file', FileType::class, array('data_class' => null,'required' => false))
        ->add('Valider',SubmitType::class);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceApresVenteBundle\Entity\RecFeedCat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'serviceapresventebundle_recfeedcat';
    }


}
