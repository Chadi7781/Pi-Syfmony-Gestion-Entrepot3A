<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\NotifiableInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Mgilet\NotificationBundle\Annotation\Notifiable;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @Notifiable(name="user")
 */
class User extends \FOS\UserBundle\Model\User implements NotifiableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="activite", type="string", length=200, nullable=true)
     */
    private $activite;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone", type="integer", nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=1000, nullable=true)
     */
    private $adresse;


    /**
     * @Assert\File(maxSize="6000000")
     */
    public  $file;
    /**
     * @var string
     * @ORM\Column(name="photo", type="string", length=1000, nullable=true)
     */
    public $photo;
    /**
     * @var string
     *
     * @ORM\Column(name="Mission", type="string", length=50, nullable=true)
     */

    private $mission;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="Date_Naissance", type="date", nullable=true)
     */
    public $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=20, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Note", type="string", length=20, nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="governat", type="string", length=20, nullable=true)
     */
    private $governat;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=50, nullable=false)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="disponible", type="string", length=50, nullable=true)
     */
    private $disponible;

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


    public function getAbsolutePath()
    {
        return null === $this->photo
            ? null
            : $this->getUploadRootDir().'/'.$this->photo;
    }

    public function getWebPath()
    {
        return null === $this->photo
            ? null
            : $this->getUploadDir().'/'.$this->photo;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../../test/test/web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the _DIR_ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'users_photo';
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

    public function UploadProfilePicture()
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
        $this->photo = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }




    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto( $photo)
    {
        $this->photo = $photo;
    }




    public function __construct()
    {
        parent::__construct();
        // your own logic
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

}
