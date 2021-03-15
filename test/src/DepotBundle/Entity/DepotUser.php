<?php

namespace DepotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * DepotUser
 *
 * @ORM\Table(name="depot_user")
 * @ORM\Entity
 */
class DepotUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_depot", type="integer", nullable=false)
     */
    private $idDepot;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var \DateTime
     *@Assert\LessThan("today UTC")
     * @ORM\Column(name="datedebut", type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime
     * @Assert\GreaterThan(propertyPath="datedebut")
     * @ORM\Column(name="datefin", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime $datedebut
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
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






}

