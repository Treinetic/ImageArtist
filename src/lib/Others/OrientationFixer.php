<?php

namespace Treinetic\ImageArtist\lib\Others;
use Treinetic\ImageArtist\lib\Image;

/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/13/17
 * Time: 11:39 PM
 */
class OrientationFixer
{

    private $filePath = null;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function getCurrentOrientation(){
        $exif = exif_read_data($this->filePath);
        return isset($exif['Orientation']) ? $exif['Orientation'] : 1;
    }

    public function fix(){
        $orientation = $this->getCurrentOrientation();
        $image = new Image($this->filePath);
        switch($orientation) {
            case 2:
                $image->flipH();
                break;
            case 3:
                $image->flipV();
                break;
            case 4:
                $image->flipV();
                $image->flipH();
                break;
            case 5:
                $image->rotate(-90);
                $image->flipH();
                break;
            case 6:
                $image->rotate(-90);
                break;
            case 7:
                $image->rotate(90);
                $image->flipH();
                break;
            case 8:
                $image->rotate(90);
                break;
        }
        return  $image;
    }

}