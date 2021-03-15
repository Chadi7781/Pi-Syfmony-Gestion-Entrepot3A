<?php

namespace EmployeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Employe
 *
 * @ORM\Table(name="employe")
 * @ORM\Entity
 */
class Employe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_emp", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmp;

    /**
     * @var string
     *
     * @ORM\Column(name="USERNAME", type="string", length=180)
     */
    private $username;

    /**
     * @Assert\NotBlank

     * @var string
     *
     * @ORM\Column(name="PRENOM", type="string", length=20, nullable=false)
     */
    private $prenom;

    /**
     * @Assert\NotBlank
     *  @Assert\Email(
     *     message = "Email '{{ value }}' non valider.",
     *     checkMX = true
     * )
     * @var string
     * @ORM\Column(name="EMAIL", type="string", length=180, nullable=false)
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=1000, nullable=false)
     */
    private $adresse;

    /**
     * @Assert\NotBlank
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_NAISSANCE", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=8,
     *     max=8,
     *     minMessage = "CIN {{ limit }} doit etre 8 chiffres",
     *     maxMessage = "CIN {{ limit }} doit etre 8 chiffres",
     *)
     * @var string
     *
     * @ORM\Column(name="CIN", type="string", length=8, nullable=false)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="ROLES", type="text", nullable=true)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="MISSION", type="string", length=50, nullable=true)
     */
    private $mission;

    /**
     * @Assert\NotBlank
     *  @Assert\Length(
     *     min=8,
     *     max=8,
     *     minMessage = "Telephone {{ limit }} doit etre 8 chiffres",
     *     maxMessage = "Telephone {{ limit }} doit etre 8 chiffres",
     *
     *     )
     * @var integer
     *
     * @ORM\Column(name="telephone", type="integer", nullable=false)
     */
    private $telephone;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="governat", type="string", length=20, nullable=true)
     */
    private $governat;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="disponible", type="string", length=50, nullable=true)
     */
    private $disponible;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=true)
     */
    private $image;
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

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param string $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

    /**
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @param string $mission
     */
    public function setMission($mission)
    {
        $this->mission = $mission;
    }

    /**
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param int $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getGovernat()
    {
        return $this->governat;
    }

    /**
     * @param string $governat
     */
    public function setGovernat($governat)
    {
        $this->governat = $governat;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * @param string $disponible
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



}

