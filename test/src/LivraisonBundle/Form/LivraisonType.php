<?php

namespace LivraisonBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LivraisonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresseDepart', TextType::class)->add('GovernatD',ChoiceType::class, [
        'choices'  => [
            'Ariana' => 'Ariana',
            'Béja' => 'Béja',
            'Ben Arous' => 'Ben Arous',
            'Bizerte' => 'Bizerte',
            'Gabès' => 'Gabès',
            'Gafsa' => 'Gafsa',
            'Jendouba' => 'Jendouba',
            'Kairouan' => 'Kairouan',
            'Kasserine' => 'Kasserine',
            'Kébili' => 'Kébili',
            'Le Kef' => 'Le Kef',
            'Mahdia' => 'Mahdia',
            'La Manouba' => 'La Manouba',
            'Médenine' => 'Médenine',
            'Monastir' => 'Monastir',
            'Nabeul' => 'Nabeul',
            'Sfax' => 'Sfax',
            'Sidi Bouzid' => 'Sidi Bouzid',
            'Siliana' => 'Siliana',
            'Sousse' => 'Sousse',
            'Tataouine' => 'Tataouine',
            'Tozeur' => 'Tozeur',
            'Tunis' => 'Tunis',
            'Zaghouan' => 'Zaghouan',
        ],'mapped' => false,
    ])->add('adresseArrive',TextType::class)->add('GovernatA',ChoiceType::class, [
            'choices'  => [
                'Ariana' => 'Ariana',
                'Béja' => 'Béja',
                'Ben Arous' => 'Ben Arous',
                'Bizerte' => 'Bizerte',
                'Gabès' => 'Gabès',
                'Gafsa' => 'Gafsa',
                'Jendouba' => 'Jendouba',
                'Kairouan' => 'Kairouan',
                'Kasserine' => 'Kasserine',
                'Kébili' => 'Kébili',
                'Le Kef' => 'Le Kef',
                'Mahdia' => 'Mahdia',
                'La Manouba' => 'La Manouba',
                'Médenine' => 'Médenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozeur' => 'Tozeur',
                'Tunis' => 'Tunis',
                'Zaghouan' => 'Zaghouan',
            ],'mapped' => false,
        ])->add('idMagasin',EntityType::class,array('class'=>'LivraisonBundle:PointCollecte','choice_label'=>'nom','multiple'=>false,'required' => false ,
                                            'empty_data'  => Null))->add('photoProduit', FileType::class, ['data_class'=>null])->add('fragile', ChoiceType::class, array(
            'choices'  => array(
                'Fragile' => 'Oui',
                'Produit n est pas Fragile' => 'Non'

            ),
            'multiple' => false,
            'expanded' => true,
            'choices_as_values' => true,
            'required' => true,
        ))->add('poids',ChoiceType::class, [
            'choices'  => [
                '0 < Poids < 10' => 1,
                '10 < Poids < 20'=> 2,
                '20 < Poids < 30' => 3,
                '+ 30' => 4
            ],
        ]);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LivraisonBundle\Entity\Livraison'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'livraisonbundle_livraison';
    }


}
