<?php

namespace ServiceApresVenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="ServiceApresVenteBundle\Repository\RatingRepository")
 */
class Rating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idrating", type="integer")
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
     * Rating constructor.
     */
    public function __construct()
    {
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
     * @ORM\ManyToOne(targetEntity="EmployeBundle\Entity\Employe")
     * @ORM\JoinColumn(name="idlivreur", referencedColumnName="ID_emp")
     */

    private $livreur;
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
     * @return mixed
     */
    public function getLivreur()
    {
        return $this->livreur;
    }

    /**
     * @param mixed $livreur
     */
    public function setLivreur($livreur)
    {
        $this->livreur = $livreur;
    }





    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $value;

}