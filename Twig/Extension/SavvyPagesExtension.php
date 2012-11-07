<?php

namespace Savvy\PagesBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author  Luke Rotherfield <luke@saavvycreativeuk.com>
 */
class SavvyPagesExtension extends \Twig_Extension
{

    /**
     * Container
     *
     * @var ContainerInterface
     */
    protected $container;
    protected $server, $save_path = false;
    protected $settings = array(), $colours = array();

    /**
     * Initialize tinymce  helper
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'savvy_pages';
    }
    

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'media_show' => new \Twig_Function_Method($this, 'mediaShow', array('is_safe' => array('html'))),
            'media_system' => new \Twig_Function_Method($this, 'mediaSystem', array('is_safe' => array('html'))),
            'get_controller_name' => new \Twig_Function_Method($this, 'getControllerName'),
            'get_action_name' => new \Twig_Function_Method($this, 'getActionName'),
            'nice_selling_type' => new \Twig_Function_Method($this, 'getSellingTypeTranslation', array('is_safe' => array('html'))),
            'auto_p' => new \Twig_Function_Method($this, 'automatedParagraphs', array('is_safe' => array('html'))),
        );
    }

    public function getFilters()
    {
        return array(
            'string_to_array' => new \Twig_Filter_Method($this, 'stringToArray'),
        );
    }

    public function stringToArray($string, $delimeter)
    {
        if (is_string($string)) {
            return explode($delimeter, $string);
        } elseif (is_object($string) && method_exists($string, 'getId')) {
            return array($string->getId());
        }
        return array();
    }

    /**
     * Show file
     */
    public function mediaShow($id = 1, $class = '', $size = 'thumb', $route_only = false, $absolute = false)
    {
        return $this->getContainer()->get('savvy.media.factory')->showFile($id, $class, $size, $route_only, $absolute);
    }

    /**
     * Get current controller name with optional separator
     */
    public function getControllerName($separator = "")
    {
        $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
        $matches = array();
        preg_match($pattern, $this->container->get('request')->get('_controller'), $matches);
        $matches[1] = preg_replace('/(?!^)[A-Z]/', $separator . '\0', $matches[1]);
        return strtolower($matches[1]);
    }

    /**
     * Get current action name
     */
    public function getActionName()
    {
        $pattern = "#::([a-zA-Z]*)Action#";
        $matches = array();
        preg_match($pattern, $this->container->get('request')->get('_controller'), $matches);

        return isset($matches[1]) ? $matches[1] : false;
    }

    /**
     * Return a selling type translated to TRG internal reference
     */
    public function getSellingTypeTranslation($entity)
    {
        $translations = array(
            'standard' => 'Full',
            'half' => '50/50',
            'fraction' => 'Fractional'
        );
        $string = $translations[$entity->getSellingType()->getReference()];
        if ($entity->getSellingType()->getName() == 'CASH') {
            $string .= ' (Cash)';
        } elseif ($entity->getSellingType()->getName() == 'SIPP') {
            $string .= ' (SIPP)';
        }
        return $string;
    }

    /**
     * Return text split and paragraphed on \n's
     */
    public function automatedParagraphs($text)
    {
        $text_array = explode("\n", $text);
        foreach ($text_array as &$string) {
            if ($string == '') {
                $string = '&nbsp;';
            }
        }
        return "<p>" . implode("</p>\n<p>", $text_array) . "</p>";
    }

}