
<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 10:52 AM
 */
//require_once "lib/Shapes.php";
//require_once "lib/Image.php";
//require_once "lib/Node.php";
use Treinetic\ImageArtist\lib\PolygonShape;
use Treinetic\ImageArtist\lib\Text\TextBox;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Text\Font;
use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Image;
require('../vendor/autoload.php');

/** @var $image Image $traingle_one */



/*
 * Load Image
 * */
$image = new Image("./morning.jpeg");

/*
 * Image operations
 *
 * */

echo "<h1>Image operations</h1>";

$image->scale(40); //scales the image 40%
$image->dump(); // this is a debug function only do not use this for production purposes
$image->scaleToHeight(1024); //scales the image keeping height 1024
$image->dump();
$image->scaleToWidth(1024); //scales the image keeping width 1024
$image->dump();
$image->resize(1024,768); //resizes the image to a given size
$image->dump();

/*
 * Image Attributes
 * */

echo "<h1>Image Attributes</h1>";

$new_wdith = $image->getWidth();
$new_height = $image->getHeight();
echo "Width is : $new_width  <br/>";
echo "Height is : $new_height  <br/>";

/*
 *change format save to disk
 * */

$image->save("/home/imal/Desktop/images/newImage.jpg",IMAGETYPE_PNG); //change the url according to yours


/*
 * other usefull operations
 * */

echo "<h1>Other usefull operations</h1>";

$base64URL = $image->getDataURI();
echo "<img src='$base64URL' />";
/*
    Image class will not return anything for following methods but in Shape classes it will be a new Image
    to keep the idea of Shape Consistant
 */
$image->crop(100,100,300,300);
$image->dump();
$image->merge(new Image("./city.jpg"),100,100);
$image->dump();


