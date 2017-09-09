<?php

namespace Treinetic\ImageArtist\lib\Text;

/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:10 PM
 */
class TextBox extends TextWriter
{


    private $width;
    private $height;

    public function __construct($width,$height)
    {
        $this->width = $width;
        $this->height= $height;
    }
    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }



}