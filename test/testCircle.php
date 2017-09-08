<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 07/09/2017
 * Time: 18:44
 */


require('../vendor/autoload.php');
require ('CircleCrop.php');

$img = imagecreatefromjpeg("ttt.jpg");
$crop=new \App\test\circle\CircleCrop($img);
$crop->crop()->display();