<?php

namespace VehiculeBundle\Repository;

use Doctrine\ORM\EntityRepository;
class VehiculeRepository extends EntityRepository
{
    public function updateetat($matricule)
    {
        $ql=$this->getEntityManager()->createQuery("update VehiculeBundle\Entity\Vehicule v SET v.etat='indiso' where v.matricule='124TUN124' ");
        return $query= $ql->getResult();
    }

}
?>