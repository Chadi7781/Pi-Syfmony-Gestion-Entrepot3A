<?php

namespace LivraisonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_facture", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFacture;


    /**
     * @ORM\ManyToOne(targetEntity="Livraison")
     * @ORM\JoinColumn(name="idLivraison",referencedColumnName="id_livraison")
     */
    private $idLivraison;

    /**
     * @ORM\ManyToOne(targetEntity="AchatBundle\Entity\Commande")
     * @ORM\JoinColumn(name="idCommande",referencedColumnName="id_commande")
     */
    private $idCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="type_paiement", type="string", length=100, nullable=true)
     */
    private $typePaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="type_facture", type="string", length=100, nullable=true)
     */
    private $typeFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @return int
     */
    public function getIdFacture()
    {
        return $this->idFacture;
    }

    /**
     * @param int $idFacture
     */
    public function setIdFacture($idFacture)
    {
        $this->idFacture = $idFacture;
    }

    /**
     * @return mixed
     */
    public function getIdLivraison()
    {
        return $this->idLivraison;
    }

    /**
     * @param mixed $idLivraison
     */
    public function setIdLivraison($idLivraison)
    {
        $this->idLivraison = $idLivraison;
    }

    /**
     * @return mixed
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * @param mixed $idCommande
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }

    /**
     * @return string
     */
    public function getTypePaiement()
    {
        return $this->typePaiement;
    }

    /**
     * @param string $typePaiement
     */
    public function setTypePaiement($typePaiement)
    {
        $this->typePaiement = $typePaiement;
    }

    /**
     * @return string
     */
    public function getTypeFacture()
    {
        return $this->typeFacture;
    }

    /**
     * @param string $typeFacture
     */
    public function setTypeFacture($typeFacture)
    {
        $this->typeFacture = $typeFacture;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }



}

