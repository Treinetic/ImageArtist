
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


$traingle_x = new \Treinetic\ImageArtist\lib\Shapes\Triangle("./images.jpeg");
$traingle_x->scale(40);
$traingle_x->build();
$traingle_x->dump();


$square = new \Treinetic\ImageArtist\lib\Shapes\Square("./images.jpeg");
$square->scale(40);
$square->build();
$square->dump();
/*
 * |--/
 * | /
 * |/
 *
 * */
$traingle_one = new \Treinetic\ImageArtist\lib\Shapes\Triangle("./images.jpeg");
$traingle_one->setPointA(0, 0, true);
$traingle_one->setPointB(0, 100, true);
$traingle_one->setPointC(100, 0, true);
$traingle_one->scale(40);
$traingle_one->build();


$traingle_two = new \Treinetic\ImageArtist\lib\Shapes\Triangle("./image2.jpg");
$traingle_two->setPointA(0, 100, true);
$traingle_two->setPointB(100, 100, true);
$traingle_two->setPointC(100, 0, true);
$traingle_two->resize($traingle_one->getWidth(),$traingle_one->getHeight());
$traingle_two->build();


$image = $traingle_one->merge($traingle_two, 0, 0);


$overlay = new Overlay($image->getWidth(), $image->getHeight(), new Color(51, 51, 51, 100));
$newImage = new Image($overlay);
$image = $image->merge($newImage, 0, 0);
$text_box = new TextBox(500, 150);
$text_box->setColor(Color::getColor(Color::$WHITE));
$text_box->setFont(Font::getFont(Font::$NOTOSANS_SINHALA_REGULAR));
$text_box->setText("වෙබ් මත ඕනෑම තැනක, 
ඔබ තෝරන භාෂාවෙන් ටයිප් කිරීම Google ආදාන මෙවලම් වලින් පහසු කරවයි. තවත් දැනගන්න
එය උත්සාහ කර බැලීමට, පහත දැක්වෙන ඔබේ භාෂාව සහ ආදාන මෙවලම් තෝරා ටයිප් කිරීම අරඹන්න. ");
$text_box->setText("To type any place in the web this tool will help you to do that, click any place in the text area and start
typing you will start to notice that the text is instantly getting");
$text_box->setSize(18);


$image->setTextBox($text_box,50, 50,  false);
$image->dump();


$traingle_one = new \Treinetic\ImageArtist\lib\Shapes\Triangle(new Overlay(1024,768,Color::getColor(Color::$PURPLE)));
$traingle_one->setPointA(0, 100, true);
$traingle_one->setPointB(100, 100, true);
$traingle_one->setPointC(100, 0, true);
$traingle_one->build();

$traingle_two = new \Treinetic\ImageArtist\lib\Shapes\Triangle(new Overlay(1024,768,Color::getColor(Color::$DARKPINK)));
$traingle_two->setPointA(0, 0, true);
$traingle_two->setPointB(0, 100, true);
$traingle_two->setPointC(100, 0, true);
$traingle_two->build();

$image = $traingle_two->merge($traingle_one, 0, 0);
$image->dump();
