<?php

namespace VenteBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use VenteBundle\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('desription')
            ->add('poids')
            ->add('prix')
               // ->add('idcat',
        //     EntityType::class,
       //       array('class'=>'VenteBundle:Categorie','choice_label'=>'id','multiple'=>false))
             ->add('quantite')
            ->add('photo',FileType::class,array('label' => 'insere image'))
            ->add('Ajouter',SubmitType::class , ['attr'=>['formnovalidate'=>'formnovalidate']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VenteBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ventebundle_produit';
    }


}
