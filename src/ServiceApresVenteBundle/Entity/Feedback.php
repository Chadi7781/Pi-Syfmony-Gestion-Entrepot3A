<?php

namespace ServiceApresVenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Feedback
 *
 * @ORM\Table(name="feedback")
 * @ORM\Entity(repositoryClass="ServiceApresVenteBundle\Repository\FeedbackRepository")
 */
class Feedback
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_feed", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeed;



    /**
     * @var string
     * @Assert\NotBlank(message="le champs Description est obligatoire")
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
     */
    private $description;

    /**
     * @var integer
     * @Assert\NotBlank(message="note est obligatoire")
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;



    /**
     * @ORM\ManyToOne(targetEntity="EmployeBundle\Entity\Employe")
     * @ORM\JoinColumn(name="idlivreur", referencedColumnName="ID_emp")
     */

    private $livreur;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     */

    private $user;


    /**
     * @return \DateTime
     */
    public function getDatefeedback()
    {
        return $this->datefeedback;
    }

    /**
     * @param \DateTime $datefeedback
     */
    public function setDatefeedback($datefeedback)
    {
        $this->datefeedback = $datefeedback;
    }
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






    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefeedback", type="date")
     */
    private $datefeedback;

    /**
     *
     * @ORM\ManyToOne(targetEntity="RecFeedCat")
     * @ORM\JoinColumn(name="cat",referencedColumnName="id_cat")
     */
    private $idc;

    public function __toString()
    {
        return $this->idc;
    }

    /**
     * @return int
     */
    public function getIdFeed()
    {
        return $this->idFeed;
    }

    /**
     * @param int $idFeed
     */
    public function setIdFeed($idFeed)
    {
        $this->idFeed = $idFeed;
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
        return 'uploads/feedback_image';
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
     * @return Feedback
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


}