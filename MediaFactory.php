<?php

namespace Savvy\PagesBundle;

use Symfony\Component\DependencyInjection\Container;

class MediaFactory
{

    protected $class;

    public function __construct(Container $container, $class)
    {
        $this->class = $class::getInstance($container);
    }
    
    public function showFile($id, $class, $size, $route_only, $absolute)
    {
        return $this->class->showFile($id, $class, $size, $route_only, $absolute);
    }
    
    public function showTitle($id){
        return $this->class->showTitle($id);
    }

}
