<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactureAvoir
 *
 * @ORM\Table(name="facture_avoir")
 * @ORM\Entity
 */
class FactureAvoir
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="motif_de_retour", type="string", length=85, nullable=false)
     */
    private $motifDeRetour;


}

