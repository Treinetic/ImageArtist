<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 3:02 PM
 */

namespace Treinetic\ImageArtist\Shapes;


use Treinetic\ImageArtist\Commons\Node;

class Triangle extends PolygonShape
{

    public function setPointA($x, $y, $presentage = false){
        $this->point($x,$y,$presentage);
    }

    public function setPointB($x, $y, $presentage = false){
        $this->point($x,$y,$presentage);
    }

    public function setPointC($x, $y, $presentage = false){
        $this->point($x,$y,$presentage);
    }

    public function setDefaults()
    {
        $this->setPointA(50,0,true);
        $this->setPointB(100,100, true);
        $this->setPointC(0,100,true);
    }



}