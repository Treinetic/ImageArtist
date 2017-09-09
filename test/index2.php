<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 14:42
 */


use Treinetic\ImageArtist\lib\CircularShape;

require('vendor/autoload.php');

$circileShape = new CircularShape("ttt.jpg");
$circileShape->setAxises(200,100);
$circileShape->build();


$circileShape->dump();
//$circileShape->save("res.png",IMAGETYPE_PNG);