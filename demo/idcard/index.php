<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 15/09/2017
 * Time: 14:29
 */


use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Shapes\Square;

require ('../../vendor/autoload.php');


$overlayBlue=new Overlay(275,400,new Color(50,68,142));
$overlayWhite=new Overlay(275,400,new Color(255,255,255));
$overlayBlack=new Overlay(275,400,new Color(0,0,0));
$overlayPink=new Overlay(275,400,new Color(252,55,104));



// main rectangle black border
$border=new PolygonShape($overlayBlack);
$border->push(new \Treinetic\ImageArtist\lib\Commons\Node(0,0,Node::$PIXEL_METRICS));
$border->push(new \Treinetic\ImageArtist\lib\Commons\Node(275,0,Node::$PIXEL_METRICS));
$border->push(new \Treinetic\ImageArtist\lib\Commons\Node(275,400,Node::$PIXEL_METRICS));
$border->push(new \Treinetic\ImageArtist\lib\Commons\Node(0,400,Node::$PIXEL_METRICS));
$border->build();
//$border->dump();



// main rectangle white back
$background=new PolygonShape($overlayWhite);
$background->push(new \Treinetic\ImageArtist\lib\Commons\Node(2,2,Node::$PIXEL_METRICS));
$background->push(new \Treinetic\ImageArtist\lib\Commons\Node(273,2,Node::$PIXEL_METRICS));
$background->push(new \Treinetic\ImageArtist\lib\Commons\Node(273,398,Node::$PIXEL_METRICS));
$background->push(new \Treinetic\ImageArtist\lib\Commons\Node(2,398,Node::$PIXEL_METRICS));
$background->build();
//$background->dump('white');

$mainRectangle=$border->merge($background,2,2);



// blue polygon shape
$blueBack=new PolygonShape($overlayBlue);
$blueBack->push(new \Treinetic\ImageArtist\lib\Commons\Node(2,213,Node::$PIXEL_METRICS));
$blueBack->push(new \Treinetic\ImageArtist\lib\Commons\Node(273,84,Node::$PIXEL_METRICS));
$blueBack->push(new \Treinetic\ImageArtist\lib\Commons\Node(273,398,Node::$PIXEL_METRICS));
$blueBack->push(new \Treinetic\ImageArtist\lib\Commons\Node(2,398,Node::$PIXEL_METRICS));
$blueBack->build();

$mainRectangle=$mainRectangle->merge($blueBack,2,84);


$img=new Image('./photo.jpg');

if($img->getWidth()>$img->getHeight()){
    $img->scaleToHeight(130);
}else{
    $img->scaleToWidth(100);
}

$img->crop(0,0,100,130);

//var_export($img->getWidth());
//echo '<br>';
//var_export($img->getHeight());



$imgBorder=new Square($overlayBlack);
$imgBorder->scaleToWidth(102);
$imgBorder->scaleToHeight(132);

$imgBorder->build();
echo '<br>';
var_export($imgBorder->getWidth());
echo '<br>';
var_export($imgBorder->getHeight());


$imgWithBorder=$imgBorder->merge($img,1,1);




//$photo=new PolygonShape('./photo.jpg');
//$photo->push(new \Treinetic\ImageArtist\lib\Commons\Node(78,95,Node::$PIXEL_METRICS));
//$photo->push(new \Treinetic\ImageArtist\lib\Commons\Node(178,95,Node::$PIXEL_METRICS));
//$photo->push(new \Treinetic\ImageArtist\lib\Commons\Node(178,225,Node::$PIXEL_METRICS));
//$photo->push(new \Treinetic\ImageArtist\lib\Commons\Node(78,225,Node::$PIXEL_METRICS));
//$photo->build();

$mainRectangle=$mainRectangle->merge($imgWithBorder,78,95);



$base64URL = $mainRectangle->getDataURI();
echo "<img src='$base64URL' />";



