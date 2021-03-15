<?php

namespace VenteBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="VenteBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var integer
     *
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=100, nullable=false)
     */
    private $photo;

    /**
     * @var integer
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */

    private $poids;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     * @Assert\NotBlank(message="le champs Prix est obligatoire")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="desription", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="le champs Description est obligatoire")
     */
    private $desription;

    /**
     * @var integer
     *
     * @ORM\Column(name="idcat", type="integer", nullable=true)
     */
    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="id_cat",referencedColumnName="id")
     */
    private $idcat;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_depot", type="integer", nullable=true)
     */
    private $idDepot;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="le champs libelle est obligatoire")
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Assert\NotBlank(message="le champs Quantité est obligatoire")
     */
    private $quantite;




    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser",referencedColumnName="id")
     */
    private $idUser;



    /**
     * @ORM\OneToMany(targetEntity="AchatBundle\Entity\ProduitCommande", mappedBy="produits")
     *
     */
    protected $produitcommande;





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
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
    public function getDesription()
    {
        return $this->desription;
    }

    /**
     * @param string $desription
     */
    public function setDesription($desription)
    {
        $this->desription = $desription;
    }

    /**
     * @return int
     */
    public function getIdcat()
    {
        return $this->idcat;
    }

    /**
     * @param int $idcat
     */
    public function setIdcat($idcat)
    {
        $this->idcat = $idcat;
    }

    /**
     * @return int
     */
    public function getIdDepot()
    {
        return $this->idDepot;
    }

    /**
     * @param int $idDepot
     */
    public function setIdDepot($idDepot)
    {
        $this->idDepot = $idDepot;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
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



}

