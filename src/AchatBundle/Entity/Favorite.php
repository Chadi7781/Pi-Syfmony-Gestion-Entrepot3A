<?php

namespace AchatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorite
 *
 * @ORM\Table(name="favorite")
 * @ORM\Entity
 */
class Favorite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_favorite", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFavorite;


    /**
     * @ORM\ManyToOne(targetEntity="VenteBundle\Entity\Produit")
     * @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     */
    private $produit;

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }




    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     */

    private $user;

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
     * @return int
     */
    public function getIdFavorite()
    {
        return $this->idFavorite;
    }

    /**
     * @param int $idFavorite
     */
    public function setIdFavorite($idFavorite)
    {
        $this->idFavorite = $idFavorite;
    }




}

