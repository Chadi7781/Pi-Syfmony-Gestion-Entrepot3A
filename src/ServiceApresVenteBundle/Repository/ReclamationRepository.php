<?php

namespace ServiceApresVenteBundle\Repository;

use Symfony\Component\HttpFoundation\Request;

/**
 * ReclamationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReclamationRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByUser($user)
    {
        $query = $this
            ->getEntityManager()
            ->createQuery("SELECT u FROM ServiceApresVenteBundle:Reclamation u WHERE u.iduser = ?1")
            ->setParameter(1, $user);
        return $query->getResult();
    }

    public function getByDate(\Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->andWhere('e.date BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;

    }
    public  function calculerTotalReclamation(){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(f.description)');
        $qb->from('ServiceApresVenteBundle:Reclamation','f');

        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }

    /***
     */
    public function confirmer($id)
    {


        $qb = $this->_em->createQueryBuilder();

        $q = $qb->update('ServiceApresVenteBundle:Reclamation', 'r')
            //update DemandeSponsoring p set p.etat=1 where p.id=$id
            //
            ->set('r.etat', '?1')
            ->where('r.idRec = ?2')
            ->setParameter(1, "1")
            ->setParameter(2, $id)
            ->getQuery();
        return $q->getResult();
    }



    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM ServiceApresVenteBundle:Reclamation e
                WHERE e.objet LIKE :str'            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    public function getReclamationByUser($id_Reclamation){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT f, u.username
       FROM ServicesApresVenteBundle:Reclamation
       JOIN c.user u
       WHERE c.Reclamation = :idRec"
            )
            ->setParameter('idRec', $id_Reclamation)
            ->getArrayResult();
    }

    public function getFeedbackById() {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
       FROM ServicesApresVenteBundle:Feedback  f'

            );

        $products = $query->getResult();
        return $query;
    }



    public function findCustom($input,$date) {
        $query=$this->getEntityManager()->createQuery("SELECT c from UtilisateurBundle:Covoiturage c JOIN  c.idU u 
            WHERE (c.depart LIKE :i OR c.destination LIKE :i OR u.username LIKE :i) AND (c.date<=:d AND  CURRENT_DATE ()<=c.date) ORDER BY u.username ")
            ->setParameters(array("i"=>"%".$input."%","d"=>$date));

        return $query->getResult();

    }



}
