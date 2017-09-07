<?php


/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 10:52 AM
 */


//require_once "lib/Shape.php";
//require_once "lib/Image.php";
//require_once "lib/Node.php";


use App\lib\Shape;
use App\lib\Text\TextBox;
use App\lib\Text\Color;
use App\lib\Text\Font;
use App\lib\Overlays\Overlay;
use App\lib\Image;

require('vendor/autoload.php');


/*
 * |--/
 * | /
 * |/
 *
 * */
$traingle_one = new \App\lib\Triangle("./images.jpeg");
$traingle_one->setPointOne(0, 0, true);
$traingle_one->setPointTwo(0, 100, true);
$traingle_one->setPointThree(100, 0, true);
$traingle_one->scale(40);
$traingle_one->build();


$traingle_two = new \App\lib\Triangle("./image2.jpg");
$traingle_two->setPointOne(0, 100, true);
$traingle_two->setPointTwo(100, 100, true);
$traingle_two->setPointThree(100, 0, true);
$traingle_two->scale(40);
$traingle_two->build();


$image = $traingle_one->merge($traingle_two, 0, 0);

//$shape = new Shape($image->getResource());
//$shape->pushPresentage(new \App\lib\Node(33,33));
//$shape->pushPresentage(new \App\lib\Node(66,33));
//$shape->pushPresentage(new \App\lib\Node(66,66));
//$shape->pushPresentage(new \App\lib\Node(33,66));
//$shape->build();


$overlay = new Overlay($image->getWidth(), $image->getHeight(), new Color(51, 51, 51, 100));
$newImage = new Image($overlay);

$image = $image->merge($newImage, 0, 0);
$text_box = new TextBox(500, 150);
$text_box->setColor(Color::getColor(Color::$WHITE));
$text_box->setFont(Font::getFont(Font::$ISKOLA_POTA));
$text_box->setText("වෙබ් මත ඕනෑම තැනක, 
ඔබ තෝරන භාෂාවෙන් ටයිප් කිරීම Google ආදාන මෙවලම් වලින් පහසු කරවයි. තවත් දැනගන්න
එය උත්සාහ කර බැලීමට, පහත දැක්වෙන ඔබේ භාෂාව සහ ආදාන මෙවලම් තෝරා ටයිප් කිරීම අරඹන්න. ");
$text_box->setText("To type any place in the web this tool will help you to do that, click any place in the text area and start 
typing you will start to notice that the text is instantly getting");
$text_box->setSize(32);

$image->setTextBox($text_box, 0, 100, 100, 8, true);
$image->dump();