<?php

namespace Savvy\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{

    protected $entity_manager = false;

    public function __get($parameter)
    {
        if ($parameter == "em") {
            if (!$this->entity_manager) {
                $this->entity_manager = $this->getDoctrine()->getEntityManager();
            }
            return $this->entity_manager;
        }
        if ($this->container->hasParameter($parameter)) {
            return $this->container->getParameter($parameter);
        }
        return false;
    }

    protected function findPage($slug_string, $first_page = false)
    {
        $slug_array = explode("/", $slug_string);
        $slug = array_shift($slug_array);
        $page = $this->em->getRepository("PagesBundle:Page")->getPageBySlug($slug, $this->site_id);
        if (!$page) {
            return false;
        }
        if ($first_page) {
            return $page;
        }
        while (!empty($slug_array)) {
            if ($page->getChildren()) {
                $slug = array_shift($slug_array);
                foreach ($page->getChildren() as $child_page) {
                    if ($child_page->getSlug() == $slug) {
                        $page = $child_page;
                        break;
                    }
                }
            } else {
                return false;
            }
        }
        return $page;
    }

    protected function checkEntity($entity, $name)
    {
        if (!$entity) {
            throw $this->createNotFoundException("Entity: '$name' could not be found");
        }
    }

    public static function slugify($text, $substitute = '-')
    {
        $text = preg_replace('/\W+/', $substitute, $text);
        $text = strtolower(trim($text, $substitute));
        return $text;
    }

    protected function getForwardSlug($current, $url){
        if($current->getForwardToChild() === NULL){
            return false;
        }
        $slug = '';
        $temp = $current->getForwardToChild();
        while($temp != $current){
            $slug = '/' . $temp->getSlug() . $slug;
            $temp = $temp->getParent();
        }
        return $url == '' ? $current->getSlug() . $slug : "$url/{$current->getSlug()}$slug";
    }

}