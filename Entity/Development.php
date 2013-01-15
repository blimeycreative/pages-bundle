<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\Development
 *
 * @ORM\Table(name="development")
 * @ORM\Entity()
 */
class Development
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var date $completion_date
     *
     * @ORM\Column(name="completion_date", type="date")
     */
    protected $completion_date;

    /**
     * @var boolean $hide_from_search
     *
     * @ORM\Column(name="hide_from_search", type="boolean")
     */
    protected $hide_from_search;

    /**
     * @var string $latitude
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    protected $latitude;

    /**
     * @var string $longitude
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    protected $longitude;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Savvy\PagesBundle\Entity\Gallery", mappedBy="development")
     */
    protected $cms_galleries;

    public function __construct()
    {
        $this->cms_galleries = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Set completion_date
     *
     * @param date $completionDate
     */
    public function setCompletionDate($completionDate)
    {
        $this->completion_date = $completionDate;
    }

    /**
     * Get completion_date
     *
     * @return date
     */
    public function getCompletionDate()
    {
        return $this->completion_date;
    }

    public function setHideFromSearch($hide_from_search)
    {
        $this->hide_from_search = $hide_from_search;
    }

    public function getHideFromSearch()
    {
        return $this->hide_from_search;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

}