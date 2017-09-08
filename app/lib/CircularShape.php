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



    private $major_axis;// ellipse width
    private $minor_axis;// ellipse height


    /**
     *
     * CircleShape constructor.
     */
    public function __construct($image)
    {
        parent::__construct($image);


        $this->major_axis = $this->getWidth();
        $this->minor_axis = $this->getHeight();

    }


    public function build()
    {

        $this->cropCircle();
    }


    public function setAxises($major_axis, $minor_axis )
    {
        $this->major_axis = $major_axis;
        $this->minor_axis = $minor_axis;
        return $this;
    }

    private function cropCircle()
    {
        // Intializes destination image


        $dst_img = imagecreatetruecolor($this->major_axis, $this->minor_axis);
        imagecopy($dst_img, $this->getResource(), 0, 0, 0, 0, $this->major_axis, $this->minor_axis);



        // Create a black image with a transparent ellipse, and merge with destination
        $mask = imagecreatetruecolor($this->major_axis, $this->minor_axis);
        $maskTransparent = imagecolorallocate($mask, 255, 0, 255);
        imagecolortransparent($mask, $maskTransparent);
        imagefilledellipse($mask, $this->major_axis / 2, $this->minor_axis / 2, $this->major_axis, $this->minor_axis, $maskTransparent);
        imagecopymerge($dst_img, $mask, 0, 0, 0, 0, $this->major_axis, $this->minor_axis, 100);

        // Fill each corners of destination image with transparency
        $dstTransparent = imagecolorallocate($dst_img, 255, 0, 255);
        imagefill($dst_img, 0, 0, $dstTransparent);
        imagefill($dst_img, $this->major_axis - 1, 0, $dstTransparent);
        imagefill($dst_img, 0, $this->minor_axis - 1, $dstTransparent);
        imagefill($dst_img, $this->major_axis - 1, $this->minor_axis - 1, $dstTransparent);
        imagecolortransparent($dst_img, $dstTransparent);

        // destroy old resource
        imagedestroy($this->getResource());

        // set new resource created
        $this->setResource($dst_img);
        return $this;
    }

}