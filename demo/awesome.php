<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 14:42
 */


use \Treinetic\ImageArtist\lib\Shapes\Triangle;

require('../vendor/autoload.php');

$triangle = new Triangle("./city.jpg");
$triangle->scale(60);
$triangle->setPointA(20,20,true); //setting point A, i'm using preentages but you can use px as well
$triangle->setPointB(80,20,true);
$triangle->setPointC(50,80,true);
$triangle->build();

$triangle->dump();