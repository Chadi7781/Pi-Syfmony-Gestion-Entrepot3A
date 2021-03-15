<?php

namespace LivraisonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Livraison
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\LivraisonRepository")
 */
class Livraison
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_livraison", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLivraison;

    /**
     * @Assert\NotBlank(message=" l 'adresse d'expediteur est obligatoire")
     * @Assert\Length(
     *     min=5,
     *     minMessage = "Enter une adresse valide s'il vous plait",
     *
     *     )
     * @var string
     *
     * @ORM\Column(name="adresse_depart", type="string", length=100, nullable=false)
     */
    private $adresseDepart;

    /**
     * @Assert\NotBlank(message=" l adresse destinataire est obligatoire")
     * @Assert\Length(
     *     min=5,
     *     minMessage = "Enter une adresse valide s'il vous plait",
     *
     *     )
     * @var string
     *
     * @ORM\Column(name="adresse_arrive", type="string", length=100, nullable=false)
     */
    private $adresseArrive;

    /**
     * @var integer
     *
     * @ORM\Column(name="distance", type="integer", nullable=true)
     */
    private $distance;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="photo_produit", type="string", length=100, nullable=true)
     */
    private $photoProduit;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @Assert\NotBlank(message=" vous devez choisir la fragilitèe du produit")
     * @var string
     *
     * @ORM\Column(name="fragile", type="string", length=100, nullable=true)
     */
    private $fragile;

    /**
     * @Assert\NotBlank(message=" Selectionner le poid s'il vous plait'")
     * @var integer
     *
     * @ORM\Column(name="poids", type="integer", nullable=true)
     */
    private $poids;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=100, nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="date_reception", type="string", length=100, nullable=true)
     */
    private $dateReception;

    /**
     * @ORM\ManyToOne(targetEntity="PointCollecte")
     * @ORM\JoinColumn(name="idMagasin",referencedColumnName="id_magasin")
     */
    private $idMagasin;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=true)
     */
    private $idCommande;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=true)
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_emp", type="integer", nullable=true)
     */
    private $idEmp;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=500, nullable=true)
     */
    private $matricule;

    /**
     * Livraison constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdLivraison()
    {
        return $this->idLivraison;
    }

    /**
     * @param int $idLivraison
     */
    public function setIdLivraison($idLivraison)
    {
        $this->idLivraison = $idLivraison;
    }

    /**
     * @return string
     */
    public function getAdresseDepart()
    {
        return $this->adresseDepart;
    }

    /**
     * @param string $adresseDepart
     */
    public function setAdresseDepart($adresseDepart)
    {
        $this->adresseDepart = $adresseDepart;
    }

    /**
     * @return string
     */
    public function getAdresseArrive()
    {
        return $this->adresseArrive;
    }

    /**
     * @param string $adresseArrive
     */
    public function setAdresseArrive($adresseArrive)
    {
        $this->adresseArrive = $adresseArrive;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return string
     */
    public function getPhotoProduit()
    {
        return $this->photoProduit;
    }

    /**
     * @param string $photoProduit
     */
    public function setPhotoProduit($photoProduit)
    {
        $this->photoProduit = $photoProduit;
    }

    /**
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getFragile()
    {
        return $this->fragile;
    }

    /**
     * @param string $fragile
     */
    public function setFragile($fragile)
    {
        $this->fragile = $fragile;
    }

    /**
     * @return int
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param int $poids
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return string
     */
    public function getDateReception()
    {
        return $this->dateReception;
    }

    /**
     * @param string $dateReception
     */
    public function setDateReception($dateReception)
    {
        $this->dateReception = $dateReception;
    }

    /**
     * @return int
     */
    public function getIdMagasin()
    {
        return $this->idMagasin;
    }

    /**
     * @param int $idMagasin
     */
    public function setIdMagasin($idMagasin)
    {
        $this->idMagasin = $idMagasin;
    }

    /**
     * @return int
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * @param int $idCommande
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdEmp()
    {
        return $this->idEmp;
    }

    /**
     * @param int $idEmp
     */
    public function setIdEmp($idEmp)
    {
        $this->idEmp = $idEmp;
    }



}

