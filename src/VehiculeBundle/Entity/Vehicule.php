<?php

namespace VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule")
 * @ORM\Entity(repositoryClass="VehiculeBundle\Repository\VehiculeRepository")
 */
class Vehicule
{
    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank(message="Le Champs matricule est obligatoire")
     * @Assert\Length(min=5,max=50)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    public $photo;
    /**
     *@Assert\File(maxSize="500K")
     */
    public $file;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="puissance", type="string", length=50, nullable=true)
     */
    private $puissance;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=500, nullable=true)
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=50, nullable=true)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="kilometrage", type="string", length=50, nullable=true)
     */
    private $kilometrage;

    /**
     * @var string
     *
     * @ORM\Column(name="nbPlace", type="string", length=11, nullable=true)
     */
    private $nbplace;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255, nullable=false)
     */
    private $prix;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_User",
    referencedColumnName="id")
     */
    protected $User;

    /**
     * Vehicule constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param string $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    public function getwebPath()
    {
        return null===$this->photo ? null : $this->getUploadDir.'/' .$this->photo;
    }
    protected function getUploadRootDir(){
        return __DIR__.'/../../../../test/web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){
        return 'imgvehiculess';
    }
    public function UploadProfilePicture()
    {
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $this->photo=$this->file->getClientOriginalName();
        $this->file=null;
    }

    /**
     *Set photo
     * @param string $photo
     * @return Vehicule
     */
    public function setPhoto(string $photo)
    {
        $this->photo=$photo;
        return $this;
    }
    /**
     * Get photo
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Vehicule
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuissance()
    {
        return $this->puissance;
    }

    /**
     * @param string $puissance
     */
    public function setPuissance($puissance)
    {
        $this->puissance = $puissance;
    }

    /**
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param string $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    /**
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    /**
     * @return string
     */
    public function getKilometrage()
    {
        return $this->kilometrage;
    }

    /**
     * @param string $kilometrage
     */
    public function setKilometrage($kilometrage)
    {
        $this->kilometrage = $kilometrage;
    }

    /**
     * @return string
     */
    public function getNbplace()
    {
        return $this->nbplace;
    }

    /**
     * @param string $nbplace
     */
    public function setNbplace($nbplace)
    {
        $this->nbplace = $nbplace;
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
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param string $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    public function __toString()
    {
        return $this->matricule;
    }


}

