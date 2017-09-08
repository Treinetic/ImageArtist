<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 10:44
 */

namespace Treinetic\ImageArtist\lib;


use Treinetic\ImageArtist\lib\Image;

class CircularShape extends Image implements Shapable
{



    private $dst_img;
    private $dst_w;
    private $dst_h;



    /**
     * CircleShape constructor.
     */
    public function __construct($image)
    {
        parent::__construct($image);


        $this->dst_w = $this->getWidth();
        $this->dst_h = $this->getHeight();

    }



    public function build()
    {
        $this->cropCircle();
    }




    public function __destruct()
    {
        if (is_resource($this->getResource()))
        {
            imagedestroy($this->getResource());
        }
    }


    private function reset()
    {
        if (is_resource(($this->dst_img)))
        {
            imagedestroy($this->dst_img);
        }
        $this->dst_img = imagecreatetruecolor($this->dst_w, $this->dst_h);
        imagecopy($this->dst_img, $this->getResource(), 0, 0, 0, 0, $this->dst_w, $this->dst_h);
        return $this;
    }

    public function setAxises($dstWidth, $dstHeight)
    {
        $this->dst_w = $dstWidth;
        $this->dst_h = $dstHeight;
        return $this->reset();
    }

    private function cropCircle()
    {
        // Intializes destination image
        $this->reset();

        // Create a black image with a transparent ellipse, and merge with destination
        $mask = imagecreatetruecolor($this->dst_w, $this->dst_h);
        $maskTransparent = imagecolorallocate($mask, 255, 0, 255);
        imagecolortransparent($mask, $maskTransparent);
        imagefilledellipse($mask, $this->dst_w / 2, $this->dst_h / 2, $this->dst_w, $this->dst_h, $maskTransparent);
        imagecopymerge($this->dst_img, $mask, 0, 0, 0, 0, $this->dst_w, $this->dst_h, 100);

        // Fill each corners of destination image with transparency
        $dstTransparent = imagecolorallocate($this->dst_img, 255, 0, 255);
        imagefill($this->dst_img, 0, 0, $dstTransparent);
        imagefill($this->dst_img, $this->dst_w - 1, 0, $dstTransparent);
        imagefill($this->dst_img, 0, $this->dst_h - 1, $dstTransparent);
        imagefill($this->dst_img, $this->dst_w - 1, $this->dst_h - 1, $dstTransparent);
        imagecolortransparent($this->dst_img, $dstTransparent);
        $this->setResource($this->dst_img);
        return $this;
    }

}