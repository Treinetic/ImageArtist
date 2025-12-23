<?php
namespace Treinetic\ImageArtist\Text\Write;
use Treinetic\ImageArtist\Helpers\GDUtils;
use Treinetic\ImageArtist\Helpers\ImageHelper;
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;
use Treinetic\ImageArtist\Text\TextWriter;

/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/12/17
 * Time: 10:09 AM
 */
class ImagickWritingStrategy implements WritingStrategy
{
    /** @var  \Treinetic\ImageArtist\Text\TextWriter $textWriter */
    private $textWriter;
    private $imageHelper;

    public function __construct()
    {
        $this->imageHelper = new ImageHelper();
    }

    public function write()
    {


//        $angle;


        $writer = $this->textWriter;
        /** @var Font $font */
        $font = $writer->getFont();
        /** @var Color $color */
        $color = $writer->getColor();

        $im = new \Imagick();
        $background = new \ImagickPixel('none');

        $im->setBackgroundColor($background);


        $im->setFont($font->getPath());
        $im->setPointSize($writer->getSize());
        $im->setGravity(\Imagick::GRAVITY_EAST); //later we will have to change this

        $width = $writer->getWidth();
        $height = $writer->getHeight();
        $text = $writer->getText();
        $margin = $writer->getMargin();
        $angle = $writer->getAngle();

        $im->newPseudoImage($width, $height, "pango:" . $text );
        $clut = new \Imagick();
        $clut->newImage(2, 2, new \ImagickPixel($color->toString()));
        $im->clutImage($clut);
        $clut->destroy();

        $im->setImageFormat("png");
        $image = imagecreatefromstring($im->getImageBlob());
        $template = $this->imageHelper->createTransparentTemplate($width+ (2*$margin),$height+ (2 *$margin));

        $img = new Image($template);
        $text = new Image($image);

        imagedestroy($image);
        imagedestroy($template);

        $img = $img->merge($text,$margin,$margin);

        if($angle != 0){
            $pngTransparency = imagecolorallocatealpha($img->getResource() , 0, 0, 0, 127 );
            $resource = imagerotate($img->getResource(), $angle, $pngTransparency);
            $img = new Image($resource);
            imagedestroy($resource);
        }

        return $img;
    }


    public function setWriter(TextWriter $textWriter)
    {
       $this->textWriter = $textWriter;
    }
}