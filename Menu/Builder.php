<?php
namespace Savvy\PagesBundle\Menu;

use Knp\Menu\FactoryInterface;
use Savvy\PagesBundle\Controller\BaseController;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;

class Builder extends BaseController
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $root = $this->em->getRepository("PagesBundle:Page")->getPageBySlug(NULL, $this->container->getParameter("site_id"));
        $this->dynamicMenu($root, $menu, 2);
        return $menu;
    }
    
    public function sideMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $slug = $this->getRequest()->attributes->get('slug');
        $page = $this->findPage($slug, true);
        $this->checkEntity($page, "Page");
        $this->dynamicMenu($page, $menu, 4, $page->getSlug());
        return $menu;
    }
    
    private function dynamicMenu($page, $menu, $level, $url = ''){
        if($level > 0 && $page->getChildren()){
            foreach($page->getChildren() as $child){
                $slug = $url == '' ? $child->getSlug() : "$url/{$child->getSlug()}";
                $child_menu = $menu->addChild($child->getName(), array(
                    'route' => 'page_index',
                    'routeParameters' => array('slug' => $slug)
                ));
                if($level - 1 > 0){
                    $this->dynamicMenu($child, $child_menu, $level - 1, $slug);
                }
            }
        }
        
    }
}