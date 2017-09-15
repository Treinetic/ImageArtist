<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 7:43 PM
 */

namespace Treinetic\ImageArtist\lib\Overlays;



use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use Treinetic\ImageArtist\lib\Shapes\Square;
use Treinetic\ImageArtist\lib\Text\Color;

class Overlay extends Square
{
    public function __construct($width,$height,Color $color)
    {
        $im = imagecreate($width, $height);
        imagesavealpha($im, true);
        $color = imagecolorallocatealpha($im, $color->getR(), $color->getG(), $color->getB(),$color->getAlpha());
        imagefilledrectangle($im, 0, 0, $width, $height, $color);
        parent::__construct($im);
    }
}