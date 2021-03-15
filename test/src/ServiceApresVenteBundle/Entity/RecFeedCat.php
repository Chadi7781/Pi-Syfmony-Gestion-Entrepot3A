<?php

namespace ServiceApresVenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecFeedCat
 *
 * @ORM\Table(name="rec_feed_cat")
 * @ORM\Entity
 */
class RecFeedCat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cat", type="integer",nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_cat;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;



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
     * @return int
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }

    /**
     * @param int $id_cat
     */
    public function setIdCat($id_cat)
    {
        $this->id_cat = $id_cat;
    }

    public function __toString()

    {
        return (string)$this->id_cat;
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
        return 'uploads/catRecFeed_image';
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
     * @return RecFeedCat
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

