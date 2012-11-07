<?php

namespace Savvy\PagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Savvy\PagesBundle\Entity\Layout;
use Savvy\PagesBundle\Entity\LayoutField;

/**
 * Savvy\PagesBundle\Entity\LayoutLayoutField
 *
 * @ORM\Table(name="layout_layout_field")
 * @ORM\Entity
 */
class LayoutLayoutField {

  /**
   * @var entity $layout
   * 
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Layout", inversedBy="fields")
   * @ORM\JoinColumn(name="layout_id", referencedColumnName="id", onDelete="CASCADE")
   */
  protected $layout;

  /**
   * @var entity $layout_field
   * 
   * @ORM\ManyToOne(targetEntity="LayoutField")
   * @ORM\JoinColumn(name="layout_field_id", referencedColumnName="id", onDelete="CASCADE")
   */
  protected $layout_field;

  /**
   * @var string $name
   * 
   * @ORM\Id
   * @ORM\Column(name="name", type="string", length=255)
   */
  protected $name;
  

  /**
   * Set layout
   *
   * @param entity $layout
   */
  public function setLayout(Layout $layout) {
    $this->layout = $layout;
  }

  /**
   * Get layout
   *
   * @return entity 
   */
  public function getLayout() {
    return $this->layout;
  }

  /**
   * Set layout_field
   *
   * @param entity $layoutField
   */
  public function setLayoutField(LayoutField $layoutField) {
    $this->layout_field = $layoutField;
  }

  /**
   * Get layout_field
   *
   * @return entity
   */
  public function getLayoutField() {
    return $this->layout_field;
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

}