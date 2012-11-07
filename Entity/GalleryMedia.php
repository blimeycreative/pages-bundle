<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Oxygen\PropertyBundle\Entity\PropertyTypeFeature
 *
 * @ORM\Table(name="gallery_media")
 * @ORM\Entity
 */
class GalleryMedia
{

    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    protected $value;

    /**
     * @var string $is_main
     *
     * @ORM\Column(name="is_main", type="boolean")
     */
    protected $is_main;

    /**
     * @var string $media_data
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Savvy\PagesBundle\Entity\Media", inversedBy="galleries")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $media_data;

    /**
     * @var array $gallery_data
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Savvy\PagesBundle\Entity\Gallery", inversedBy="files")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $gallery_data;
    protected $forms = array();

    public function __construct()
    {
        $this->is_main = false;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getMediaData()
    {
        return $this->media_data;
    }

    public function setMediaData($media_data)
    {
        $this->media_data = $media_data;
    }

    public function getGalleryData()
    {
        return $this->gallery_data;
    }

    public function setGalleryData($gallery_data)
    {
        $this->gallery_data = $gallery_data;
    }

    public function setForm($name, $form)
    {
        $this->forms[$name] = $form;
    }

    public function getForm($name)
    {
        return $this->forms[$name];
    }

    public function getIs_main()
    {
        return $this->is_main;
    }

    public function setIs_main($is_main)
    {
        $this->is_main = $is_main;
    }

}