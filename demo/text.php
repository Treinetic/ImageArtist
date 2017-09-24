<?php
/**
 * Created by PhpStorm.
 * User: imal
 * Date: 9/24/17
 * Time: 9:30 PM
 */

use Treinetic\ImageArtist\lib\PolygonShape;
use Treinetic\ImageArtist\lib\Text\TextBox;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Text\Font;
use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Text\Write\WriteFactory;
use Treinetic\ImageArtist\lib\Text\Write\GDWritingStrategy;
use Treinetic\ImageArtist\lib\Text\Write\ImagickWritingStrategy;

require('../vendor/autoload.php');


//WriteFactory::overrideWriteStrategySelection(WriteFactory::$GD_WRITING_STRAT);

/* I think I should add some Text */
$textBox = new TextBox(299,150);
$textBox->setColor(Color::getColor(Color::$WHITE));
$textBox->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
$textBox->setSize(20);
$textBox->setMargin(20);
$textBox->setAngle(20);
$textBox->setText("We Are Team Treinetic We Are Team Treinetic");

$img = $textBox->getImage();
$img->dump("red");
