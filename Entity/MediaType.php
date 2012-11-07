<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\MediaType
 *
 * @ORM\Table(name="media_type")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\MediaTypeRepository")
 */
class MediaType {

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
   * @var string $extension
   *
   * @ORM\Column(name="extension", type="string", length=255)
   */
  protected $extension;

  /**
   * @var array $files
   * 
   * @ORM\OneToMany(targetEntity="Media", mappedBy="media_type")
   */
  protected $files;

  public function __construct() {
    $this->files = new ArrayCollection();
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
   * Set extension
   *
   * @param string $extension
   */
  public function setExtension($extension) {
    $this->extension = $extension;
  }

  /**
   * Get extension
   *
   * @return string 
   */
  public function getExtension() {
    return $this->extension;
  }

  /**
   * Add files
   *
   * @param Savvy\PagesBundle\Entity\Media $files
   */
  public function addMedia(\Savvy\PagesBundle\Entity\Media $files) {
    $this->files[] = $files;
  }

  /**
   * Get files
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getFiles() {
    return $this->files;
  }

}