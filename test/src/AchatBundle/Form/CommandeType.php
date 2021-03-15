<?php

namespace AchatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id')->add('date')->add('adresseDest')->add('total',
            TextType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AchatBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'achatbundle_commande';
    }

    public function findallCommandesByuSER($username): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = ' SELECT * FROM ligne_commande p WHERE p.user = :username ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

}
