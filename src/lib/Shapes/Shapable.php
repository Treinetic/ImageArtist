<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 14:58
 */

namespace Treinetic\ImageArtist\lib\Shapes;


use Treinetic\ImageArtist\lib\Image;

interface Shapable
{
    public function build();

    public function setDefaults();
}