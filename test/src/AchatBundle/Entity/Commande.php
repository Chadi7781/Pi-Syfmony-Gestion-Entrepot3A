<?php

namespace AchatBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_commande", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     */

    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_dest", type="string", length=100, nullable=true)
     */
    private $adresseDest;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer", nullable=false)
     */
    private $total;


    /**
     * @ORM\OneToMany(targetEntity="ProduitCommande", mappedBy="commandes")
     */
    protected $produitcommande;

    /**
     * @return int
     */
    public function getIdCommande()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProduitcommande()
    {
        return $this->produitcommande;
    }

    /**
     * @param mixed $produitcommande
     */
    public function setProduitcommande($produitcommande)
    {
        $this->produitcommande = $produitcommande;
    }

    /**
     * @param int $idCommande
     */
    public function setIdCommande($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * @return string
     */
    public function getAdresseDest()
    {
        return $this->adresseDest;
    }

    /**
     * @param string $adresseDest
     */
    public function setAdresseDest($adresseDest)
    {
        $this->adresseDest = $adresseDest;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getCommandeproduits()
    {
        return $this->commandeproduits;
    }

    /**
     * @param mixed $commandeproduits
     */
    public function setCommandeproduits($commandeproduits)
    {
        $this->commandeproduits = $commandeproduits;
    }




    public function __construct()
    {
      //  $this-> commandeproduits= new ArrayCollection();
        //$this-> total= new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->produitcommande;
    }


}

