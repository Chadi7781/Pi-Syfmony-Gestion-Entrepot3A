<?php

namespace ServiceApresVenteBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextareaType::class, [
            'attr' => ['class' => 'tinymce','rows'=>'10'],
        ])
            ->add('note', RatingType::class, [
                'label' => 'Rating'])
//    ->add('id')
            ->add('file', FileType::class, array('data_class' => null,'required' => false))
//            ->add('idCommande')
//            ->add('datefeedback', DateType::class,array('data_class' => null,'required' => false))

//                        ->add('idc',
//                EntityType::class,array('class'=>'ServiceApresVenteBundle:Feedback',
//                'choice_label'=>'idc.nom','multiple'=>true))

        ->add('Ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceApresVenteBundle\Entity\Feedback'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'serviceapresventebundle_feedback';
    }


}
