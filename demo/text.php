<?php
/**
 * Created by PhpStorm.
 * User: imal
 * Date: 9/24/17
 * Time: 9:30 PM
 */

use Treinetic\ImageArtist\PolygonShape;
use Treinetic\ImageArtist\Text\TextBox;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;
use Treinetic\ImageArtist\Overlays\Overlay;
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Text\Write\WriteFactory;
use Treinetic\ImageArtist\Text\Write\GDWritingStrategy;
use Treinetic\ImageArtist\Text\Write\ImagickWritingStrategy;

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
