<?php

namespace ServiceApresVenteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('type')
        ->add('objet')
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce','rows'=>'10']])
            //->add('etat')
            //->add('date')
            //  ->add('id')
            ->add('file', FileType::class,array('label'=>'Image'))
            //->add('idCat');
            ->add('Valider',SubmitType::class);

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceApresVenteBundle\Entity\Reclamation'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'serviceapresventebundle_reclamation';
    }


}