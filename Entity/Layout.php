<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\Layout
 *
 * @ORM\Table(name="layout")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\LayoutRepository")
 */
class Layout
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var array $pages
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="layout")
     */
    protected $pages;

    /**
     * @var entity collection $fields
     * 
     * @ORM\OneToMany(targetEntity="LayoutLayoutField", mappedBy="layout")
     */
    protected $fields;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->fields = new ArrayCollection();
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
     * Add field
     *
     * @param Savvy\PagesBundle\Entity\LayoutLayoutField $field
     */
    public function addField(\Savvy\PagesBundle\Entity\LayoutLayoutField $field)
    {
        $this->fields[] = $field;
    }

    /**
     * Get fields
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Add fields
     *
     * @param Savvy\PagesBundle\Entity\Layout $fields
     */
    public function addLayout(\Savvy\PagesBundle\Entity\Layout $fields)
    {
        $this->fields[] = $fields;
    }

    /**
     * Add fields
     *
     * @param Savvy\PagesBundle\Entity\LayoutLayoutField $fields
     */
    public function addLayoutLayoutField(\Savvy\PagesBundle\Entity\LayoutLayoutField $fields)
    {
        $this->fields[] = $fields;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

}