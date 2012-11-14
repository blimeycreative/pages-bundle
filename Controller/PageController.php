<?php

namespace Savvy\PagesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/")
 */
class PageController extends BaseController
{

    /**
     * @Route("media/show/{id}/{size}", name="media_show")
     * @Template
     */
    public function showAction($id, $size)
    {
        $media = $this->getDoctrine()->getRepository('PagesBundle:Media')->find($id);
        if ($media) {
            if (!in_array($media->getMediaType()->getExtension(), array('png', 'gif', 'jpg'))) {
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename={$media->getFileName()}.{$media->getMediaType()->getExtension()}");
                header("Content-Transfer-Encoding: binary");
            }
            header('content-type: ' . $media->getMediaType()->getName());
            readfile($this->media_route . $media->getId() . ($size == 'non-image' ? '' : '-' . $size) . '.' . $media->getMediaType()->getExtension());
        }
        exit;
    }

    /**
     * @Route("{slug}", name="page_index", defaults={"slug" = false}, requirements={"slug" = "[0-9a-zA-Z\/\-]*"})
     * @Template()
     */
    public function indexAction($slug)
    {
        if ($slug) {
            $page = $this->findPage($slug);
            $this->checkEntity($page, "Page:$slug");
            $return = array("page" => $page);
            $contents = $this->em->getRepository('PagesBundle:Content')->getPageContents($page->getId());
            foreach($contents as $content){
                $return[$content->getType()->getName()] = $content->getValue();
            }
            return $return;
        }
        return array();
    }

}
