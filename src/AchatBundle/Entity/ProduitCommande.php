<?php

namespace AchatBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use VenteBundle\Entity\Produit;

/**
 * ProduitCommande
 *
 * @ORM\Table(name="produit_commande")
 * @ORM\Entity(repositoryClass="AchatBundle\Repository\ProduitCommandeRepository")
 */
class ProduitCommande
{


    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Commande",cascade={"persist"},inversedBy="produitcommande")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\JoinColumn(name="commande", referencedColumnName="id_commande", nullable=false)
     */
    protected $commandes;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="VenteBundle\Entity\Produit", inversedBy="produitcommande",cascade={"persist"})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\JoinColumn(name="produit", referencedColumnName="id", nullable=true)
     */
    protected $produits;



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
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commandes;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commandes = $commande;
    }

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produits;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produits = $produit;
    }




    public function addCommande(Commande $competition): self
    {
        $this->commandes[] = $competition;

        return $this;
    }

    public function addProduit($competition): array
    {
        $this->produits[] = $competition;

        return $this;
    }

    public function removceCommande(Commande $competition): bool
    {
        return $this->commandes->removeElement($competition);
    }

//    public function getCommandes(): Collection
//    {
//        return $this->commandes;
//    }


    public function __construct()
    {
        $this-> total= new ArrayCollection();
    }
}



