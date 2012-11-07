<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Savvy\PagesBundle\Entity\Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\ContentRepository")
 */
class Content
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
     * @var text $value
     *
     * @ORM\Column(name="value", type="text")
     */
    protected $value;

    /**
     * @var integer $page
     *
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="contents")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $page;

    /**
     * @var entity $type
     *
     * @ORM\ManyToOne(targetEntity="Oxygen\CmsBundle\Entity\LayoutLayoutField")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="layout_id", referencedColumnName="layout_id", onDelete="CASCADE"),
     *   @ORM\JoinColumn(name="layout_field_name", columnDefinition="VARCHAR(255)", referencedColumnName="name", onDelete="CASCADE")
     * })
     */
    protected $type;

    /**
     * @var entity $field
     *
     * @ORM\ManyToOne(targetEntity="Savvy\PagesBundle\Entity\LayoutField")
     * @ORM\JoinColumn(name="layout_field_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $field;

    /**
     * @var text $name
     *
     * @ORM\Column(name="name", type="text")
     */
    protected $name;

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
     * Set value
     *
     * @param text $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return text 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set name
     *
     * @param text $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return text 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set page
     *
     * @param Savvy\PagesBundle\Entity\Page $page
     */
    public function setPage(\Savvy\PagesBundle\Entity\Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Savvy\PagesBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set type
     *
     * @param Savvy\PagesBundle\Entity\LayoutLayoutField $type
     */
    public function setType(\Savvy\PagesBundle\Entity\LayoutLayoutField $type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return Savvy\PagesBundle\Entity\LayoutLayoutField 
     */
    public function getType()
    {
        return $this->type;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;
    }

}