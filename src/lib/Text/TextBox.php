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


    

    public function __construct($width,$height)
    {
        parent::__construct();
        $this->setWidth($width);
        $this->setHeight($height);
    }




}