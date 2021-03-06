<?php

namespace Savvy\PagesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Null;

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
        error_log("MediaCacheFile: Attempt file read for media id: '$id'");
        if ($media) {

            header("Cache-Control: max-age=604800, public, must-revalidate");
            if (!in_array($media->getMediaType()->getExtension(), array('png', 'gif', 'jpg'))) {
                error_log("MediaCacheFile: render file as its not an image");
                $file = "{$this->media_route}$id.{$media->getMediaType()->getExtension()}";
                $fileInfo = new \finfo(FILEINFO_MIME);
                $content_type = $fileInfo->file($file);
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $content_type);
                header("Content-Disposition: attachment; filename={$media->getFileName()}.{$media->getMediaType()->getExtension()}");
                header('Content-Transfer-Encoding: binary');
                header('Connection: Keep-Alive');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));

                error_log($file);

                readfile($file);
                exit;
            }
            if (!$width && !$height) {
                error_log("MediaCacheFile: no width or height set so no need to create cache file");
                readfile(
                    $this->media_route . $media->getId() . ($size == 'non-image' ? '' : '-' . $size) . '.' . $media
                        ->getMediaType()->getExtension()
                );
            } else {
                if (!file_exists($this->media_cache_route)) {
                    error_log("MediaCacheFile: createing cache directory");
                    mkdir($this->media_cache_route, "0777", true);
                }
                $cache_file = false;
                foreach (
                    array('jpg' => "image/jpeg", 'png' => 'image/png', 'gif' => 'image/gif') as $extension =>
                    $content_type
                ) {
                    if (file_exists($this->media_cache_route . "$id-$width-$height.$extension")) {
                        error_log("MediaCacheFile: Cache file exists");
                        $cache_file = true;
                        break;
                    }
                }
                if (!$cache_file) {
                    // Read the current media file into imagick
                    $im = new \Imagick(
                        $this->media_route . $media->getId() . ($size == 'non-image' ? '' : '-' . $size) . '.' . $media
                            ->getMediaType()->getExtension());

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
                            $x = ($width - $geometry['width']) / 2;
                            $y = ($height - $geometry['height']) / 2;

                            /* Composite on the canvas  */
                            $canvas->compositeImage($im, \Imagick::COMPOSITE_OVER, $x, $y);
                            // Route starts in web folder
                            $canvas->writeImage($this->media_cache_route . "$id-$width-$height.png");
                            $extension = 'png';
                            $content_type = 'image/png';
                            error_log(
                                "MediaCacheFile: png file written: " . $this->media_cache_route . "$id-$width-$height.png"
                            );
                        } else {
                            if ($crop) {
                                $im->cropthumbnailImage($width, $height);
                            } else {
                                $im->thumbnailImage($width, $height);
                            }
                            $extension = 'jpg';
                            $content_type = 'image/jpeg';
                            error_log("MediaCacheFile: jpg type chosen");
                            $im->setImageFormat('jpeg');
                            error_log("MediaCacheFile: jpg format set");
                            $im->setImageCompressionQuality(80);
                            error_log("MediaCacheFile: compression quality set to 80");
                            $im->writeImage($this->media_cache_route . "$id-$width-$height.jpg");
                            error_log(
                                "MediaCacheFile: jpg file written: " . $this->media_cache_route . "$id-$width-$height.jpg"
                            );
                        }
                    } elseif($width > 0 && $height == false) {
                        $im->thumbnailImage($width, 0, false);
                        $extension = 'jpg';
                        $content_type = 'image/jpeg';
                        error_log("MediaCacheFile: jpg type chosen");
                        $im->setImageFormat('jpeg');
                        error_log("MediaCacheFile: jpg format set");
                        $im->setImageCompressionQuality(80);
                        error_log("MediaCacheFile: compression quality set to 80");
                        $im->writeImage($this->media_cache_route . "$id-$width-$height.jpg");
                        error_log(
                            "MediaCacheFile: jpg file written: " . $this->media_cache_route . "$id-$width-$height.jpg"
                        );
                    } else {
                        $extension = $media->getMediaType()->getExtension();
                        $content_type = $media->getMediaType()->getName();
                        $im->writeImage(
                            $this->media_cache_route . "$id-$width-$height.{$media->getMediaType()->getExtension()}"
                        );
                    }
                }
                error_log("MediaCacheFile: Rendering cache file");
                header('content-type: ' . $content_type);
                $file = "{$this->media_cache_route}$id-$width-$height.$extension";
                $last_modified_time = filemtime($file);
                $etag = md5_file($file);

                header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
                header("Etag: $etag");

                readfile($file);
            }
        }
        exit;
    }

    /**
     * @Route("construction_gallery/{date}/{gallery_id}/{development}", name="construction_gallery", defaults={"development" = false})
     * @Template()
     */
    public function constructionGalleryAction($gallery_id, $development = false)
    {
        $gallery = $this->em->getRepository("PagesBundle:Gallery")->find($gallery_id);
        $this->checkEntity($gallery, "Construction gallery");
        if ($gallery->getGalleryType()->getName() !== "construction") {
            throw $this->createNotFoundException("Sorry, incorrect gallery type access attempted");
        }

        return array("gallery" => $gallery);
    }

    /**
     * @Route("{slug}", name="page_index", defaults={"slug" = false}, requirements={"slug" = "[0-9a-zA-Z\/\-]*"})
     * @Template()
     */
    public function indexAction($slug)
    {
        if ($slug !== false) {
            $page = $this->findPage($slug);
            $this->checkEntity($page, "Page:$slug");
            if ($this->getForwardSlug($page, $slug, false)) {
                return $this->redirect(
                    $this->generateUrl('page_index', array('slug' => $this->getForwardSlug($page, $slug, false)))
                );
            }
            $response = new Response();
            $response->setLastModified($page->getUpdatedAt());
            // Set response as public. Otherwise it will be private by default.
            $response->setPublic();

            if ($response->isNotModified($this->getRequest())) {
                return $response;
            }
            /* Page title if not set */
            if ($page->getTitle() == null) {
                $page->setTitle($page->getHeading());
            }
            $return = array("page" => $page);
            $contents = $this->em->getRepository('PagesBundle:Content')->getPageContents($page->getId());
            foreach ($contents as $content) {
                $return[self::slugify($content->getType()->getName(), "_")] = $content->getValue();
            }

            return $this->render('PagesBundle:Page:index.html.twig', $return, $response);
        }

        return array();
    }


}
