<?php

require 'vendor/autoload.php';

use Treinetic\ImageArtist\Shapes\CircularShape;

// Create a blank image to act as source
$width = 500;
$height = 500;
$img = imagecreatetruecolor($width, $height);
$red = imagecolorallocate($img, 255, 0, 0);
imagefill($img, 0, 0, $red);
imagepng($img, 'test_source.png');

// Create Circle
$circle = new CircularShape('test_source.png');
$circle->build();
$circle->save('test_circle_output.png', IMAGETYPE_PNG);

echo "Created test_circle_output.png\n";
