<?php
namespace Treinetic\ImageArtist\lib\Text\Write;
use Treinetic\ImageArtist\lib\Helpers\GDUtils;
use Treinetic\ImageArtist\lib\Helpers\ImageHelper;
use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Text\TextWriter;

/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/12/17
 * Time: 10:09 AM
 */

class GDWritingStrategy implements WritingStrategy
{
    /** @var  \Treinetic\ImageArtist\lib\Text\TextWriter $textWriter */
    private $textWriter;
    /** @var  ImageHelper $imageHelper */
    private $imageHelper;

    public function __construct()
    {
        $this->imageHelper = new ImageHelper();
    }

    public function write()
    {
        $text = $this->textWriter->getText();
        $width = $this->textWriter->getWidth();
        $height = $this->textWriter->getHeight();
        $text_new = $this->createText($text,$width);
        $resource = $this->imageHelper->createTransparentTemplate($width,$height);
        $this->writeTextToResource($resource,$text_new,0,0);
        return $resource;
    }

    public function setWriter(TextWriter $textWriter)
    {
        $this->textWriter = $textWriter;
    }


    private function createText($text,$width){
        $font = $this->textWriter->getFont();
        $font_size = $this->textWriter->getSize();
        $angle = $this->textWriter->getAngle();
        $font_path = $font->getPath();

        $text_a = explode(' ', $text);
        $text_new = '';
        foreach($text_a as $word){
            //Create a new text, add the word, and calculate the parameters of the text
            $box = imagettfbbox($font_size, 0, $font_path, $text_new.' '.$word);
            //if the line fits to the specified width, then add the word with a space, if not then add word with new line
            if($box[2] > $width - $this->textWriter->getMargin()*2){
                $text_new .= "\n".$word;
            } else {
                $text_new .= " ".$word;
            }
        }
        return trim($text_new);
    }

    private function writeTextToResource(&$resource,$textModified,$x,$y){
        $font = $this->textWriter->getFont();
        $clr = $this->textWriter->getColor();

        $color = imagecolorallocatealpha($resource, $clr->getR(), $clr->getG(), $clr->getB(), $clr->getAlpha());
        $font_path = $font->getPath();
        $font_size = GDUtils::pointsToCurrentGDSupportedMetrics($this->textWriter->getSize());
        $margin = $this->textWriter->getMargin();
        $angle = $this->textWriter->getAngle();

        imagettftext(
            $resource,
            $font_size,
            0,
            $x+$margin,
            $y+$font_size+$margin,
            $color,
            $font_path,
            $textModified
        );
        if($angle != 0){
            $pngTransparency = imagecolorallocatealpha($resource , 0, 0, 0, 127 );
            $resource = imagerotate($resource, $angle, $pngTransparency);
        }
    }
}