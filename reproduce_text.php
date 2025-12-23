<?php

require 'vendor/autoload.php';

use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Text\TextBox;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;

// Create a blank image
$img = imagecreatetruecolor(500, 200);
$bg = imagecolorallocate($img, 100, 100, 100);
imagefill($img, 0, 0, $bg);
// Save initial image to load it via ImageArtist
imagepng($img, 'test_text_source.png');

$image = new Image('test_text_source.png');

$textBox = new TextBox(400, 100);
$textBox->setColor(new Color(255, 255, 255));
$textBox->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
$textBox->setSize(20);
$textBox->setText("Hello World");

$image->setTextBox($textBox, 50, 50);
$image->save('test_text_output.png', IMAGETYPE_PNG);

echo "Created test_text_output.png\n";
