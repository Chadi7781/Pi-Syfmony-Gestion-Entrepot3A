<?php


namespace VenteBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CategorieRepository extends EntityRepository
{
    public function  myfindbyid()
    {   $qb=$this->getEntityManager()->
    createQuery("select c from VenteBundle:Categorie c");
        return $query= $qb->getResult();

    }
    public  function calculerTotal(){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(f.nom)');
        $qb->from('VenteBundle:Categorie','f');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;


    }


    public function findbyMe3()
    {
        $Query=$this->getEntityManager()
            ->createQuery("SELECT l FROM VenteBundle:Categorie l 
         order by l.prix DESC ");

        return $Query->getResult();

    }
}