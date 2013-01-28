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
            'media_title' => new \Twig_Function_Method($this, 'mediaTitle', array('is_safe' => array('html'))),
            'get_controller_name' => new \Twig_Function_Method($this, 'getControllerName'),
            'get_action_name' => new \Twig_Function_Method($this, 'getActionName'),
            'nice_selling_type' => new \Twig_Function_Method($this, 'getSellingTypeTranslation', array('is_safe' => array('html'))),
            'auto_p' => new \Twig_Function_Method($this, 'automatedParagraphs', array('is_safe' => array('html'))),
            'has_nav_two' => new \Twig_Function_Method($this, 'hasNavTwo'),
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
     * Show file title
     */
    public function mediaTitle($id = 1)
    {
        return $this->getContainer()->get('savvy.media.factory')->showTitle($id);
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
     * Return text split and paragraphed on \n's
     */
    public function automatedParagraphs($text)
    {
        $text_array = explode("\n", $text);
        foreach ($text_array as $key => $string) {
            if (self::stripper($string) === false) {
                unset($text_array[$key]);
            }
        }
        return "<p>" . implode("</p>\n<p>", $text_array) . "</p>";
    }

    public function hasNavTwo()
    {
        $slug_string = $this->container->get('request')->attributes->get('slug');
        $slug_array = explode("/", $slug_string);
        $slug = array_shift($slug_array);
        $em = $this->container->get('doctrine')->getManager();
        $page = $em->getRepository("PagesBundle:Page")->getPageBySlug($slug, $this->container->getParameter("site_id"));
        foreach ($page->getChildren() as $child) {
            return true;
        }
        return false;
    }

    public static function stripper($val)
    {
        foreach (array(" ", "&nbsp;", "\n", "\t", "\r") as $strip) {
            $val = str_replace($strip, '', (string) $val);
        }
        return $val === '' ? false : $val;
    }

}
