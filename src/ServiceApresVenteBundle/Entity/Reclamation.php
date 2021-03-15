<?php

namespace ServiceApresVenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;
/**
 * Reclamation
 * @ORM\Table(name="reclamation")
 * @Notifiable(name="reclamation")
 * @ORM\Entity(repositoryClass="ServiceApresVenteBundle\Repository\ReclamationRepository")
 */
class Reclamation implements  NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_rec", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;








    /**
     * @ORM\ManyToOne(targetEntity="AchatBundle\Entity\Commande",cascade={"persist"})
     * @ORM\JoinColumn(name="commandeProduit", referencedColumnName="id_commande" )
     */
    private $commandeproduits;

    /**
     * @ORM\ManyToOne(targetEntity="VenteBundle\Entity\Produit",cascade={"persist"})
     * @ORM\JoinColumn(name="produit", referencedColumnName="id" )
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
     * @return mixed
     */
    public function getCommandeproduits()
    {
        return $this->commandeproduits;
    }

    /**
     * @param mixed $commandeproduits
     */
    public function setCommandeproduits($commandeproduits)
    {
        $this->commandeproduits = $commandeproduits;
    }

    /**
     * @return mixed
     */
    public function getProduitcommandes()
    {
        return $this->produitcommandes;
    }

    /**
     * @param mixed $produitcommandes
     */
    public function setProduitcommandes($produitcommandes)
    {
        $this->produitcommandes = $produitcommandes;
    }









    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     */

    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="S'il vous plait inserer objet")
     *  * @Assert\Length(
     *     min=5,
     *     max=90,
     *     minMessage="l'objet doit etre au minimum  5 caractere",
     *     maxMessage="l'objet doit etre au minimum  90 caractere"
     * )
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     *  * @Assert\NotBlank(message="S'il vous plait inserer description")
     *  * @Assert\Length(
     *     min=10,
     *     max=500,
     *     minMessage="la description doit etre au minimum  10 caractere",
     *     maxMessage="la description doit etre au minimum  500 caractere"
     * )
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public  $file;


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;




    public function getAbsolutePath()
    {
        return null === $this->image
            ? null
            : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image
            ? null
            : $this->getUploadDir().'/'.$this->image;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../../test/test/web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the _DIR_ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/reclamation_image';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->image = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }















    /**
     *Set image
     * @param string $image
     * @return Reclamation
     */
    public function setImage(string $image)
    {
        $this->image=$image;
        return $this;
    }
    /**
     * Get image
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }



    /**
     * @return mixed
     */
    public function getIdc()
    {
        return $this->idc;
    }

    /**
     * @param mixed $idc
     */
    public function setIdc($idc)
    {
        $this->idc = $idc;
    }

    /**
     *
     * @ORM\ManyToOne(targetEntity="RecFeedCat")
     * @ORM\JoinColumn(name="cat" ,referencedColumnName="id_cat" ,nullable=true, onDelete="CASCADE")
     */
    private $idc;

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
    public function getIdRec()
    {
        return $this->idRec;
    }

    /**
     * @param int $idRec
     */
    public function setIdRec($idRec)
    {
        $this->idRec = $idRec;
    }

    /**
     * @return string
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param string $objet
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
//
//    public function __toString()
//    {
//        // TODO: Implement __toString() method.
//        return $this->getCommande();
//    }


}