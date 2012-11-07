<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Savvy\PagesBundle\Entity\MediaPath
 *
 * @ORM\Table(name="media_path")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\MediaPathRepository")
 */
class MediaPath {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string $path
   *
   * @ORM\Column(name="path", type="string", length=255)
   */
  protected $path;

  /**
   * @var string $children
   * 
   * @ORM\OneToMany(targetEntity="MediaPath", mappedBy="parent")
   */
  protected $children;

  /**
   * @var integer $parent
   *
   * @ORM\ManyToOne(targetEntity="MediaPath", inversedBy="children")
   * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
   */
  protected $parent;

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
   * @var array $files
   * 
   * @ORM\OneToMany(targetEntity="Media", mappedBy="media_path")
   */
  protected $files;

  /**
   * @var form $forms
   */
  protected $forms = array();
  protected $parent_id;

  public function __construct() {
    $this->files = new ArrayCollection();
  }

  public function __toString() {
    return $this->path;
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
   * Set path
   *
   * @param string $path
   */
  public function setPath($path) {
    $this->path = $path;
  }

  /**
   * Get path
   *
   * @return string 
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Set lft
   *
   * @param integer $lft
   */
  public function setLft($lft) {
    $this->lft = $lft;
  }

  /**
   * Get lft
   *
   * @return integer 
   */
  public function getLft() {
    return $this->lft;
  }

  /**
   * Set rght
   *
   * @param integer $rght
   */
  public function setRght($rght) {
    $this->rght = $rght;
  }

  /**
   * Get rght
   *
   * @return integer 
   */
  public function getRght() {
    return $this->rght;
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

  /**
   * Set parent_id
   *
   * @param integer $parentId
   */
  public function setParentId($parentId) {
    $this->parent_id = $parentId;
  }

  /**
   * Get parent_id
   *
   * @return integer 
   */
  public function getParentId() {
    return $this->parent_id;
  }

  /**
   * Add children
   *
   * @param Savvy\PagesBundle\Entity\MediaPath $children
   */
  public function addMediaPath(\Savvy\PagesBundle\Entity\MediaPath $children) {
    $this->children[] = $children;
  }

  /**
   * Get children
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getChildren() {
    return $this->children;
  }

  /**
   * Set parent
   *
   * @param Savvy\PagesBundle\Entity\MediaPath $parent
   */
  public function setParent(\Savvy\PagesBundle\Entity\MediaPath $parent) {
    $this->parent = $parent;
  }

  /**
   * Get parent
   *
   * @return Savvy\PagesBundle\Entity\MediaPath 
   */
  public function getParent() {
    return $this->parent;
  }

  /**
   * Set a form by name
   * 
   * @param string $form 
   * @param string $name 
   */
  public function setForm($name, $form) {
    $this->forms[$name] = $form;
  }

  /**
   * Get a form by name
   * 
   * @param string $name
   * @return form 
   */
  public function getForm($name) {
    return $this->forms[$name];
  }

}