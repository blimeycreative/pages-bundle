<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Savvy\PagesBundle\Entity\Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="Savvy\PagesBundle\Entity\MediaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Media {

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
   * @var string $file_name
   *
   * @ORM\Column(name="file_name", type="string", length=255)
   */
  protected $file_name;

  /**
   * @var string $media_type
   * 
   * @ORM\ManyToOne(targetEntity="MediaType", inversedBy="files")
   * @ORM\JoinColumn(name="media_type_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
   */
  protected $media_type;

  /**
   * @var string $media_path
   * 
   * @ORM\ManyToOne(targetEntity="MediaPath", inversedBy="files")
   * @ORM\JoinColumn(name="media_path_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
   */
  protected $media_path;

  /**
   * @var datetime $created
   * 
   * @ORM\Column(name="created", type="datetime");
   */
  protected $created;

  /**
   * @var integer $media_path_id
   */
  protected $media_path_id;

  /**
   * @var form $forms
   */
  protected $forms = array();
  
  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get media_path_id
   *
   * @return integer 
   */
  public function getMediaPathId() {
    return $this->media_path_id;
  }

  /**
   * Set media_path_id
   *
   * @return integer 
   */
  public function setMediaPathId($id) {
    $this->media_path_id = $id;
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
   * Set file_name
   *
   * @param string $fileName
   */
  public function setFileName($fileName) {
    $this->file_name = $fileName;
  }

  /**
   * Get file_name
   *
   * @return string 
   */
  public function getFileName() {
    return $this->file_name;
  }

  /**
   * Set media_type
   *
   * @param Savvy\PagesBundle\Entity\MediaType $mediaType
   */
  public function setMediaType(\Savvy\PagesBundle\Entity\MediaType $mediaType) {
    $this->media_type = $mediaType;
  }

  /**
   * Get media_type
   *
   * @return Savvy\PagesBundle\Entity\MediaType 
   */
  public function getMediaType() {
    return $this->media_type;
  }

  /**
   * Set media_path
   *
   * @param Savvy\PagesBundle\Entity\MediaPath $mediaPath
   */
  public function setMediaPath(\Savvy\PagesBundle\Entity\MediaPath $mediaPath) {
    $this->media_path = $mediaPath;
  }

  /**
   * Get media_path
   *
   * @return Savvy\PagesBundle\Entity\MediaPath 
   */
  public function getMediaPath() {
    return $this->media_path;
  }

  /**
   * @ORM\PrePersist
   */
  public function setTimestamps() {
    $this->setCreated(new \DateTime());
  }

  /**
   * Set created
   *
   * @param datetime $created
   */
  public function setCreated($created) {
    $this->created = $created;
  }

  /**
   * Get created
   *
   * @return datetime 
   */
  public function getCreated() {
    return $this->created;
  }
  
  /**
   * Set a form by name
   * 
   * @param string $form 
   * @param string $name 
   */
  public function setForm($name,$form) {
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