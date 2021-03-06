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
        $root = $this->em->getRepository("PagesBundle:Page")->getPageBySlug(
            null,
            $this->container->getParameter("site_id")
        );
        $this->dynamicMenu($root, $menu, $this->nav_one_depth);

        return $menu;
    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $slug = $this->getRequest()->attributes->get('slug');
        $page = $this->findPage($slug, true);
        $this->checkEntity($page, "Page");
        $this->dynamicMenu($page, $menu, $this->nav_two_depth, $page->getSlug());

        return $menu;
    }

    public function constructionMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $data = $this->findConstructionGallery();
        $params = array();
        if($data['development']){
            $params['development'] = $data['development'];
        }
        foreach ($data["galleries"] as $gallery) {
            $menu->addChild(
                $gallery->getCreatedDate()->format("jS F Y"),
                array(
                     'route'           => 'construction_gallery',
                     'routeParameters' => array('gallery_id' => $gallery->getId(), 'date' => $gallery->getCreatedDate()->format("d-m-Y")) + $params
                )
            );
        }

        return $menu;
    }

    private function dynamicMenu($page, $menu, $level, $url = '')
    {
        if ($level > 0 && $page->getChildren()) {
            foreach ($page->getChildren() as $child) {
                $slug = $url == '' ? $child->getSlug() : "$url/{$child->getSlug()}";
                if ($this->getForwardSlug($child, $url)) {
                    $menu_slug = $this->getForwardSlug($child, $url);
                } else {
                    $menu_slug = $slug;
                }
                $child_menu = $menu->addChild(
                    $child->getName(),
                    array(
                         'route'           => 'page_index',
                         'routeParameters' => array('slug' => $menu_slug)
                    )
                );
                if ($level - 1 > 0) {
                    $this->dynamicMenu($child, $child_menu, $level - 1, $slug);
                }
            }
        }

    }
}