<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\GalleryRepository")
 */
class Gallery
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;
    
    /**
     * @ORM\Column(name="created_date", type="date")
     */
    protected $date;
    
    /**
     * @var array $pages
     *
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="galleries")
     */
    protected $pages;

    /**
     * @var string $gallery_type
     *
     * @ORM\ManyToOne(targetEntity="GalleryType", inversedBy="galleries")
     * @ORM\JoinColumn(name="gallery_type_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $gallery_type;

    /**
     * @var array $files
     *
     * @ORM\OneToMany(targetEntity="Savvy\PagesBundle\Entity\GalleryMedia", mappedBy="gallery_data")
     */
    protected $files;

    /**
     * @var array $sites
     *
     * @ORM\ManyToMany(targetEntity="Site", inversedBy="galleries")
     */
    protected $sites;

    public function __construct()
    {
        $this->date = new \DateTime;
        $this->pages = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->sites = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gallery_type
     *
     * @param Savvy\PagesBundle\Entity\GalleryType $galleryType
     */
    public function setGalleryType(\Savvy\PagesBundle\Entity\GalleryType $galleryType)
    {
        $this->gallery_type = $galleryType;
    }

    /**
     * Get gallery_type
     *
     * @return Savvy\PagesBundle\Entity\GalleryType
     */
    public function getGalleryType()
    {
        return $this->gallery_type;
    }

    /**
     * Add files
     *
     * @param Savvy\PagesBundle\Entity\Media $files
     */
    public function addMedia(\Savvy\PagesBundle\Entity\Media $files)
    {
        $this->files[] = $files;
    }

    /**
     * Get files
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add pages
     *
     * @param Savvy\PagesBundle\Entity\Page $pages
     */
    public function addPage(\Savvy\PagesBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;
    }

    /**
     * Get pages
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }


    /**
     * Add sites
     *
     * @param Savvy\PagesBundle\Entity\Site $sites
     */
    public function addSite(\Savvy\PagesBundle\Entity\Site $sites)
    {
        $this->sites[] = $sites;
    }

    /**
     * Get sites
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }
}