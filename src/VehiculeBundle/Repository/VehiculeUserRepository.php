<?php

namespace VehiculeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use VehiculeBundle\Entity\VehiculeUser;
use VehiculeBundle\Form\VehiculeUserType;

class VehiculeUserRepository extends EntityRepository
{
    public function getDateFinLocation($idUser)
    {
    $qb=$this->createQueryBuilder('v')
        ->join('v.matricule ' ,'c')
        ->addSelect('c')
        ->where('query',$idUser);
    return $qb->getQuery()->getResult();
    }
}
?>