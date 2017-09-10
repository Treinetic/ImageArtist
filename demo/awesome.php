<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 14:42
 */


use \Treinetic\ImageArtist\lib\Shapes\Triangle;
use \Treinetic\ImageArtist\lib\Shapes\PolygonShape;
use \Treinetic\ImageArtist\lib\Commons\Node;
use \Treinetic\ImageArtist\lib\Text\Color;
use \Treinetic\ImageArtist\lib\Overlays\Overlay;

require('../vendor/autoload.php');

$triangle = new Triangle("./city.jpg");
$triangle->scale(60);
$triangle->setPointA(20,20,true); //setting point A, i'm using preentages but you can use px as well
$triangle->setPointB(80,20,true);
$triangle->setPointC(50,80,true);
$triangle->build();

//$triangle->dump();

/*
 * Pentagon
 * */

$pentagon = new PolygonShape("./morning.jpeg");
$pentagon->scale(60);
$pentagon->push(new Node(50,0, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(75,50, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(62.5,100, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(37.5,100, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(25,50, Node::$PERCENTAGE_METRICS));
$pentagon->build();

//$pentagon->dump();


/*
 * Merge images
 * */

$img1 = new Overlay(400,300, Color::getColor(Color::$DARKPINK));
$img2 = new Overlay(200,200, Color::getColor(Color::$PURPLE));

$img1->dump();
$img2->dump();

$img3 = $img1->merge($img2,-$img2->getWidth(),-$img2->getHeight());
$img3->dump();