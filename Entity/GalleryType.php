<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\GalleryType
 *
 * @ORM\Table(name="gallery_type")
 * @ORM\Entity
 */
class GalleryType {

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
   * @var array $galleries
   *
   * @ORM\OneToMany(targetEntity="Gallery", mappedBy="gallery_type")
   */
  protected $galleries;

  public function __construct() {
    $this->galleries = new ArrayCollection();
  }

  public function __toString() {
    return ucfirst($this->name);
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Add galleries
   *
   * @param Savvy\PagesBundle\Entity\Gallery $galleries
   */
  public function addGallery(\Savvy\PagesBundle\Entity\Gallery $gallery) {
    $this->galleries[] = $gallery;
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