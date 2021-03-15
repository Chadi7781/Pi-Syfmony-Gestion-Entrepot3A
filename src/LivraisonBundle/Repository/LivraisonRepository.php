<?php
namespace LivraisonBundle\Repository;


class LivraisonRepository extends \Doctrine\ORM\EntityRepository
{


    public function findLivraisonByUser($id)
    {


        $qb = $this->createQueryBuilder('l');
        $qb->where('l.idUser=:id')


            ->setParameter('id', $id);


        return $qb->getQuery()->getResult();

    }
    public function Confirmeretat($idLivraison)
    {


        $qb = $this->getEntityManager()->createQuery("Update LivraisonBundle:Livraison l SET l.etat = :test where l.idLivraison=:liv")

            ->setParameters(array('test'=>'Confirmer','liv'=>$idLivraison))
        ->execute();



    }
}
