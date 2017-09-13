<?php
/**
 * Created by PhpStorm.
 * User: imal
 * Date: 9/10/17
 * Time: 6:30 AM
 */

namespace Treinetic\ImageArtist\lib\Shapes;


use Treinetic\ImageArtist\lib\Image;

class Shape extends Image
{

    /*
     * Following Image methods will be overriden in the Shapes
     * reason for that is, Shape is an image that is true but
     * once that shape is merged with any other image or if you crop it
     * then that particular shape does not exists anymore
     * to avoid that and keep the concept of shape consistant we are not damaging to the existing image
     * instead we are returning a new Image
     *
     * */

    public function merge(Image $image,$pos_x, $pos_y){
        $n = new Image($this->getResource());
        return $n->merge($image,$pos_x, $pos_y);
    }

    public function crop($x,$y,$width,$height){
        $n = new Image($this->getResource());
        return $n->crop($x,$y,$width,$height);
    }





}