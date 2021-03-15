<?php


namespace VenteBundle\Repository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

class ProduitRepository extends EntityRepository
{
    public function findProduitByUser($id)
    {


        $qb = $this->createQueryBuilder('l');
        $qb->where('l.idUser=:id')


            ->setParameter('id', $id);


        return $qb->getQuery()->getResult();

    }

    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e
                FROM VenteBundle:Produit e
                WHERE e.libelle LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    public function findbyMe($id)
    {
             $Query=$this->getEntityManager()
            ->createQuery("SELECT l FROM VenteBundle:Produit l WHERE l.id=:id ")
                 ->setParameter('id',$id);
            return $Query->getResult();

    }
    public function findbyMe3()
    {
        $Query=$this->getEntityManager()
            ->createQuery("SELECT l FROM VenteBundle:Produit l 
         order by l.prix DESC ");

        return $Query->getResult();

    }
    public function findbyMeAsc()
    {
        $Query=$this->getEntityManager()
            ->createQuery("SELECT l FROM VenteBundle:Produit l 
         order by l.prix ASC ");

        return $Query->getResult();

    }
    public function findtotal()
    {
        $Query=$this->getEntityManager()
            ->createQuery("SELECT count(l.id) FROM VenteBundle:Produit l 
         ");

        try {
            return $Query->getSingleScalarResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

    }



//********By amal *******(
    public function findProduit($prix,$user){
        $query=$this->getEntityManager()
            ->createQuery("SELECT c FROM  VenteBundle:Produit c JOIN c.idUser u
                                  WHERE c.prix LIKE :prix OR u.username LIKE :user 
                                  ")
            ->setParameter("prix",'%'.$prix.'%' )
            ->setParameter("user",'%'.$user.'%' );

        return $query->getResult();
    }


}