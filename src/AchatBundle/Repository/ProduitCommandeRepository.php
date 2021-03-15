<?php

namespace AchatBundle\Repository;

use EmployeBundle\Entity\Employe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * ProduitCommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitCommandeRepository extends \Doctrine\ORM\EntityRepository
{

    public function findallCommandesByuSER($user):array
    {
        $query = $this
            ->getEntityManager()
            ->createQuery("SELECT u FROM AchatBundle:ProduitCommande u WHERE u.quantite = ?1")
            ->setParameter(1, $user);
        return $query->getResult();
    }













//    public function getFeedbackByUser($id_feedback){
//        return $this->getEntityManager()
//            ->createQuery(
//                "SELECT f, u.username
//       FROM ServicesApresVenteBundle:Feedback
//       JOIN c.user u
//       WHERE c.feedback = :id"
//            )
//            ->setParameter('id', $id_feedback)
//            ->getArrayResult();
//    }

//    public function getFeedbackById() {
//        $query = $this->getEntityManager()
//            ->createQuery(
//            'SELECT p
//       FROM ServicesApresVenteBundle:Feedback  f'
//
//        );
//
//        $products = $query->getResult();
//        return $query;
//    }

}
