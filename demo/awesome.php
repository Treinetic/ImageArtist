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
use \Treinetic\ImageArtist\lib\Shapes\CircularShape;
use \Treinetic\ImageArtist\lib\Text\TextBox;
use \Treinetic\ImageArtist\lib\Text\Font;

require('../vendor/autoload.php');

/** @var \Treinetic\ImageArtist\lib\Image $img */


$triangle = new Triangle("./city.jpg");
$triangle->scale(60);
$triangle->setPointA(20,20,true); //setting point A, i'm using preentages but you can use px as well
$triangle->setPointB(80,20,true);
$triangle->setPointC(50,80,true);
$triangle->build();

$triangle->dump();

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

$pentagon->dump();


/*
 * Merge images
 * */

$tr1 = new Triangle("./city.jpg");
$tr1->scale(60);
$tr1->setPointA(0,0,true);
$tr1->setPointB(100,0,true);
$tr1->setPointC(100,100,true);
$tr1->build();

$tr2 = new Triangle("./morning.jpeg");
$tr2->scale(60);
$tr2->setPointA(0,0,true);
$tr2->setPointB(0,100,true);
$tr2->setPointC(100,100,true);
$tr2->build();

$tr1->resize($tr1->getWidth(),$tr2->getHeight());

$img = $tr1->merge($tr2,0,0);
$img->scale(70);

$img->dump();


/* Let's add an overlay to this */
$overlay = new Overlay($img->getWidth(),$img->getHeight(),new Color(0,0,0,80));
$img->merge($overlay,0,0);
/* hmmm.. lets add a photo */
$circle = new CircularShape("./person.jpg");
$circle->build();
$img = $img->merge($circle,($img->getWidth()-$circle->getWidth())/2,($img->getHeight() - $circle->getHeight())/2);
/* I think I should add some Text */
$textBox = new TextBox(310,40);
$textBox->setColor(Color::getColor(Color::$WHITE));
$textBox->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
$textBox->setSize(20);
$textBox->setMargin(2);
$textBox->setText("We Are Team Treinetic");
$img->setTextBox($textBox,($img->getWidth()-$textBox->getWidth())/2,$img->getHeight()* (5/7));

$img->dump();