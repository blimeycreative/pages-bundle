<?php

namespace Savvy\PagesBundle;

use Symfony\Component\DependencyInjection\Container;

class Media
{

    protected $container;
    protected static $instance;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public static function getInstance($container)
    {
        if (!self::$instance)
            self::$instance = new Media($container);
        return self::$instance;
    }


    public function showFile($id, $class, $size, $route_only, $absolute)
    {
        $em = $this->container->get('doctrine')->getManager();
        $media = $em->getRepository('PagesBundle:Media')->find($id);
        if (!$media)
            return;
        $type_image = in_array($media->getMediaType()->getExtension(), array('png', 'gif', 'jpg'));
        $route = $this->container->get('router')->generate('media_show', array('id' => $id, 'size' => $type_image ? $size : 'non-image'), $absolute);
        if ($route_only === true) {
            return $route;
        } elseif ($type_image) {
            return sprintf('<img src="%1$s" alt="%2$s" title="%2$s" class="%3$s" />', $route, $media->getFileName(), $class);
        } else {
            return sprintf('<a href="%s" class="%s %s savvy_pages_file" title="%s"></a>', $route, $class, $media->getMediaType()->getExtension(), $media->getFileName() . '.' . $media->getMediaType()->getExtension());
        }
    }

    public function showTitle($id){
        $em = $this->container->get('doctrine')->getManager();
        $media = $em->getRepository('PagesBundle:Media')->find($id);
        if (!$media)
            return;
        return $media->getFileName();
    }
}