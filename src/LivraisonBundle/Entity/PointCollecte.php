<?php

namespace LivraisonBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PointCollecte
 *
 * @ORM\Table(name="point_collecte")
 * @ORM\Entity
 */
class PointCollecte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_magasin", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMagasin;

    /**
     * @Assert\NotBlank(message=" tout les champs sont obligatoires")
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=100, nullable=false)
     */
    private $pays;

    /**
     * @Assert\NotBlank(message=" tout les champs sont obligatoires")
     * @var integer
     *
     * @ORM\Column(name="log", type="string",length=500, nullable=true)
     */
    private $log;

    /**
     * @Assert\NotBlank(message=" tout les champs sont obligatoires")
     * @var integer
     *
     * @ORM\Column(name="lat", type="string",length=500, nullable=true)
     */
    private $lat;

    /**
     * @Assert\NotBlank(message=" tout les champs sont obligatoires")
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message=" tout les champs sont obligatoires")
     * @var string
     *
     * @ORM\Column(name="horaire_travail", type="string", length=100, nullable=true)
     */
    private $horaireTravail;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="jour", type="string", length=100, nullable=true)
     */
    private $jour;

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
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return int
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param int $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * @return int
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param int $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getHoraireTravail()
    {
        return $this->horaireTravail;
    }

    /**
     * @param string $horaireTravail
     */
    public function setHoraireTravail($horaireTravail)
    {
        $this->horaireTravail = $horaireTravail;
    }




}

