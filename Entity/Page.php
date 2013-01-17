<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\PageRepository")
 */
class Page
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
     * @var integer $lft
     *
     * @ORM\Column(name="lft", type="integer")
     */
    protected $lft;

    /**
     * @var integer $rght
     *
     * @ORM\Column(name="rght", type="integer")
     */
    protected $rght;

    /**
     * @var sting $name
     *
     * @ORM\ Column (name="name", type="string")
     */
    protected $name;

    /**
     * @var sting $title
     *
     * @ORM\ Column (name="title", type="string")
     */
    protected $title;

    /**
     * @var sting $heading
     *
     * @ORM\ Column (name="heading", type="string")
     */
    protected $heading;

    /**
     * @var sting $meta_tag
     *
     * @ORM\ Column (name="meta_tag", type="text", nullable=true)
     */
    protected $meta_tag;

    /**
     * @var sting $slug
     *
     * @ORM\ Column (name="slug", type="string")
     */
    protected $slug;

    /**
     * @var string $layout
     *
     * @ORM\ManyToOne(targetEntity="Layout", inversedBy="pages")
     * @ORM\JoinColumn(name="layout_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $layout;

    /**
     * @var array $contents
     *
     * @ORM\OneToMany(targetEntity="Content", mappedBy="page")
     */
    protected $contents;

    /**
     * @var array $galleries
     *
     * @ORM\ManyToMany(targetEntity="Gallery", inversedBy="pages")
     */
    protected $galleries;

    /**
     * @var entity $children
     * 
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"}) 
     */
    protected $children;

    /**
     * @var entity $parent
     * 
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children") 
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $parent;

    /**
     * @var integer $site
     *
     * @ORM\ManyToOne(targetEntity="Savvy\PagesBundle\Entity\Site", inversedBy="pages")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $site;

    /**
     * If a child is selected, forward link to child rather than self
     * @var entity $forward_to_child
     * @ORM\ManyToOne(targetEntity="Savvy\PagesBundle\Entity\Page")
     * @ORM\JoinColumn(name="forward_to_child", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $forward_to_child;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->galleries = new ArrayCollection();
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
     * Set lft
     *
     * @param integer $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rght
     *
     * @param integer $rght
     */
    public function setRght($rght)
    {
        $this->rght = $rght;
    }

    /**
     * Get rght
     *
     * @return integer
     */
    public function getRght()
    {
        return $this->rght;
    }

    /**
     * Set rght
     *
     * @param integer $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get rght
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return sting
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set layout
     *
     * @param Savvy\PagesBundle\Entity\Layout $layout
     */
    public function setLayout(\Savvy\PagesBundle\Entity\Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * Get layout
     *
     * @return Savvy\PagesBundle\Entity\Layout 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Add contents
     *
     * @param Savvy\PagesBundle\Entity\Content $contents
     */
    public function addContent(\Savvy\PagesBundle\Entity\Content $contents)
    {
        $this->contents[] = $contents;
    }

    /**
     * Get contents
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Add galleries
     *
     * @param Savvy\PagesBundle\Entity\Gallery $galleries
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

    /**
     * Reset galleries
     */
    public function resetGalleries()
    {
        $this->galleries = new ArrayCollection();
    }

    /**
     * Add children
     *
     * @param Savvy\PagesBundle\Entity\Page $children
     */
    public function addPage(\Savvy\PagesBundle\Entity\Page $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param Savvy\PagesBundle\Entity\Page $parent
     */
    public function setParent(\Savvy\PagesBundle\Entity\Page $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Savvy\PagesBundle\Entity\Page 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set site
     *
     * @param Savvy\PagesBundle\Entity\Site $site
     */
    public function setSite(\Savvy\PagesBundle\Entity\Site $site)
    {
        $this->site = $site;
    }

    /**
     * Get site
     *
     * @return Savvy\PagesBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set forward_to_child
     *
     * @param Oxygen\CmsBundle\Entity\Page $forwardToChild
     */
    public function setForwardToChild($forwardToChild)
    {
        $this->forward_to_child = $forwardToChild;
    }

    /**
     * Get forward_to_child
     *
     * @return Oxygen\CmsBundle\Entity\Page 
     */
    public function getForwardToChild()
    {
        return $this->forward_to_child;
    }

    /**
     * @param \Savvy\PagesBundle\Entity\sting $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return \Savvy\PagesBundle\Entity\sting
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param \Savvy\PagesBundle\Entity\sting $meta_tag
     */
    public function setMetaTag($meta_tag)
    {
        $this->meta_tag = $meta_tag;
    }

    /**
     * @return \Savvy\PagesBundle\Entity\sting
     */
    public function getMetaTag()
    {
        return $this->meta_tag;
    }

}