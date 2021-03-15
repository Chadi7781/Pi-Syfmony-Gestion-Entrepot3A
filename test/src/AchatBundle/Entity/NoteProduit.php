<?php

namespace AchatBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use VenteBundle\Entity\Produit;

/**
 * NoteProduit
 *
 * @ORM\Table(name="note_produit")
 * @ORM\Entity
 */
class NoteProduit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_note", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNote;

    /**
     * @ORM\ManyToOne(targetEntity="VenteBundle\Entity\Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @return int
     */
    public function getIdNote()
    {
        return $this->idNote;
    }

    /**
     * @param int $idNote
     */
    public function setIdNote($idNote)
    {
        $this->idNote = $idNote;
    }

    /**
     * @return Produit
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param Produit $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return User
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param User $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }


}

