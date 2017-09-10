<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 10:44
 */

namespace Treinetic\ImageArtist\lib\Shapes;


use Treinetic\ImageArtist\lib\Commons\Node;

class CircularShape extends Shape implements Shapable
{


    private $major_axis;// ellipse width
    private $minor_axis;// ellipse height
    /** @var  Node $center */
    private $center; // elipse center

    /**
     *
     * CircleShape constructor.
     */
    public function __construct($image)
    {
        parent::__construct($image);
    }


    public function build()
    {
        // by putting the conditins here as well gives users easily override setDefaults method
        // without worrynig about the conditions
        if(empty($this->major_axis) || empty($this->minor_axis) || empty($this->center)){
            $this->setDefaults();
        }
        $this->cropCircle();
    }

    /*
     * ( -- major -- \minor    )
     *
     * */
    public function setAxises($major_axis, $minor_axis)
    {
        $this->major_axis = $major_axis;
        $this->minor_axis = $minor_axis;
        return $this;
    }

    public function setCenter($x, $y)
    {
        $this->center = new Node($x, $y);
    }

    private function cropCircle()
    {

        $width = $this->major_axis * 2;
        $height = $this->minor_axis * 2;
        $pointX = $this->center->getX() - $this->major_axis;
        $pointY = $this->center->getY() - $this->minor_axis;

        // Intializes destination image
        $dst_img = imagecreatetruecolor($width, $height);
        imagecopy($dst_img, $this->getResource(), 0, 0, $pointX, $pointY, $width, $height);

        // Create a black image with a transparent ellipse, and merge with destination
        $mask = imagecreatetruecolor($width, $height);
        $maskTransparent = imagecolorallocate($mask, 255, 0, 255);
        imagecolortransparent($mask, $maskTransparent);
        imagefilledellipse($mask, $width / 2, $height / 2, $width, $height, $maskTransparent);
        imagecopymerge($dst_img, $mask, 0, 0, 0, 0, $width, $height, 100);

        // Fill each corners of destination image with transparency
        $dstTransparent = imagecolorallocate($dst_img, 255, 0, 255);
        imagefill($dst_img, 0, 0, $dstTransparent);
        imagefill($dst_img, $width - 1, 0, $dstTransparent);
        imagefill($dst_img, 0, $height - 1, $dstTransparent);
        imagefill($dst_img, $width - 1, $height - 1, $dstTransparent);
        imagecolortransparent($dst_img, $dstTransparent);

        // destroy old resource
        imagedestroy($this->getResource());

        // set new resource created
        $this->setResource($dst_img);
        return $this;
    }

    function setDefaults(){
        if(empty($this->major_axis) || empty($this->minor_axis)){
            $this->major_axis = $this->getWidth()/2;
            $this->minor_axis = $this->getHeight()/2;
        }
        if(empty($this->center)){
            $this->center = new Node($this->getWidth()/2, $this->getHeight()/2);
        }
    }
}