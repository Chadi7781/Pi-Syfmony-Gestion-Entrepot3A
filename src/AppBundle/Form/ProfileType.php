<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                ->add('file', 'file')        ;
    }

    public function getParent(){
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix(){
        return 'app_user_edit_profile';
    }

    // For Symfony 2.x
    public function getName(){
        return $this->getBlockPrefix();
    }
}