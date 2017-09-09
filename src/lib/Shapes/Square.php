<?php
/**
 * Created by PhpStorm.
 * User: imal
 * Date: 9/10/17
 * Time: 4:00 AM
 */

namespace Treinetic\ImageArtist\lib\Shapes;


class Square extends PolygonShape
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

    public function setPointD($x, $y, $presentage = false){
        $this->point($x,$y,$presentage);
    }

    public function setDefaults()
    {
        $this->setPointA(0,0,true);
        $this->setPointB(100,0, true);
        $this->setPointC(100,100,true);
        $this->setPointD(0,100,true);
    }

}