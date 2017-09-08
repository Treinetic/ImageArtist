<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 3:02 PM
 */

namespace Treinetic\ImageArtist\lib;


class Triangle extends Shape
{

    public function setPointOne($x,$y,$presentage = false){
        $this->point($x,$y,$presentage);
    }

    public function setPointTwo($x,$y,$presentage = false){
        $this->point($x,$y,$presentage);
    }

    public function setPointThree($x,$y,$presentage = false){
        $this->point($x,$y,$presentage);
    }

    private function point($x,$y,$presentage = false){
        $node = new Node($x,$y);
        if($presentage){
            $this->pushPresentage($node);
        }else{
            $this->push($node);
        }
    }

}