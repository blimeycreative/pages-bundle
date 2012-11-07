<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity
 */
class Site
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
     * @var array $pages
     *
     * @ORM\OneToMany(targetEntity="Savvy\PagesBundle\Entity\Page", mappedBy="site")
     */
    protected $pages;

    /**
     * @var array $galleries
     *
     * @ORM\ManyToMany(targetEntity="Gallery", mappedBy="sites")
     */
    protected $galleries;
    
    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->galleries = new ArrayCollection();
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
     * Add galleries
     *
     * @param Savvy\PagesBundle\Entity\Site $galleries
     */
    public function addGallery(\Savvy\PagesBundle\Entity\Gallery $galleries)
    {
        $this->galleries[] = $galleries;
    }

    /**
     * Get galleries
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGalleries()
    {
        return $this->galleries;
    }
}