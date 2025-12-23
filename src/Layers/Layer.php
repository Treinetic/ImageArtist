<?php

namespace Treinetic\ImageArtist\Layers;

use Treinetic\ImageArtist\Image;

class Layer
{
    private $image;
    private $x = 0;
    private $y = 0;
    private $opacity = 100;
    private $visible = true;

    public function __construct(Image $image, $x = 0, $y = 0)
    {
        $this->image = $image;
        $this->x = $x;
        $this->y = $y;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function setPosition($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    public function setOpacity($opacity)
    {
        $this->opacity = $opacity;
        return $this;
    }

    public function getOpacity()
    {
        return $this->opacity;
    }

    public function isVisible()
    {
        return $this->visible;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }
}
