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
     * @Route("media/show/{id}/{size}/{width}/{height}/{crop}/{composite}", name="media_show", defaults={"size"="large", "width"=false, "height"=false, "crop"=true, "composite"=false})
     * @Template
     */
    public function showAction($id, $size, $width, $height, $crop, $composite)
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
            if (!$width && !$height) {
                readfile($this->media_route . $media->getId() . ($size == 'non-image' ? '' : '-' . $size) . '.' . $media->getMediaType()->getExtension());
            } else {
                if (!file_exists($this->media_cache_route)) {
                    mkdir($this->media_cache_route, "0777", true);
                }
                if (!file_exists($this->media_cache_route . "$id-$width-$height.{$media->getMediaType()->getExtension()}")) {
                    // Read the current media file into imagick
                    $im = new \Imagick($this->media_route . $media->getId() . ($size == 'non-image' ? '' : '-' . $size) . '.' . $media->getMediaType()->getExtension());

                    if ($width > 0 && $height > 0) {
                        if ($composite) {
                            if ($crop) {
                                $im->cropthumbnailImage($width, $height);
                            } else {
                                /**
                                 * Fit the image into $width x $height box
                                 * The third parameter fits the image into a "bounding box"
                                 */
                                $im->thumbnailImage($width, $height, true);
                            }

                            /* Create a canvas with the desired color */
                            $canvas = new \Imagick();
                            $canvas->newImage($width, $height, 'transparent', 'png');

                            /* Get the image geometry */
                            $geometry = $im->getImageGeometry();

                            /* The overlay x and y coordinates */
                            $x = ( $width - $geometry['width'] ) / 2;
                            $y = ( $height - $geometry['height'] ) / 2;

                            /* Composite on the canvas  */
                            $canvas->compositeImage($im, \Imagick::COMPOSITE_OVER, $x, $y);
                            // Route starts in web folder
                            $canvas->writeImage($this->media_cache_route . "$id-$width-$height.{$media->getMediaType()->getExtension()}");
                        } else {
                            if ($crop) {
                                $im->cropthumbnailImage($width, $height);
                            } else {
                                $im->thumbnailImage($width, $height);
                            }
                            $im->setImageCompression(\Imagick::COMPRESSION_UNDEFINED);
                            $im->setImageCompressionQuality(0);
                            $im->writeImage($this->media_cache_route . "$id-$width-$height.{$media->getMediaType()->getExtension()}");
                        }
                    } else {
                        $im->writeImage($this->media_cache_route . "$id-$width-$height.{$media->getMediaType()->getExtension()}");
                    }
                }
                readfile("{$this->media_cache_route}$id-$width-$height.{$media->getMediaType()->getExtension()}");
            }
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
            foreach ($contents as $content) {
                $return[self::slugify($content->getType()->getName(), "_")] = $content->getValue();
            }
            return $return;
        }
        return array();
    }

}
