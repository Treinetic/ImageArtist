<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:12 PM
 */

namespace Treinetic\ImageArtist\lib\Text;


use Treinetic\ImageArtist\lib\Image;

class TextWriter
{
    private $color;
    private $font;
    private $text;
    private $size;
    private $margin;
    private $angle;

    public function __construct()
    {
        $this->setAngle(0);
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param mixed $font
     */
    public function setFont($font)
    {
        $this->font = $font;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * @param mixed $margin
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;
    }

    /**
     * @return mixed
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @param mixed $angle
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;
    }

    public function write($resource,$x,$y,$width,$height){

        /** @var Font $font */
        $font = $this->getFont();

        $text = $this->getText();
        $font_size = $this->getSize();
        $font_path = $font->getPath();
        $angle = $this->getAngle();

        $text_new = $this->createText($text,$width);
        //new text height
        $this->writeTextToResource($resource,$text_new,$x,$y);
    }

    public function buildText($width,$height){
        /** @var Font $font */
        $font = $this->getFont();

        $text = $this->getText();
        $font_size = $this->getSize();
        $font_path = $font->getPath();
        $angle = $this->getAngle();
        $margin = $this->getMargin();

        $text_new = $this->createText($text,$width);
        $box = imagettfbbox($font_size, $angle, $font_path, $text_new);
        $height_1 = $box[1] + $font_size + $this->getMargin() * 2;
        $height = $height_1 > $height ?  $height_1 : $height;

        $resource = imagecreate($width, $height);
        $color = imagecolorallocateAlpha($resource, 0, 0, 0,127);
        imagefilledrectangle($resource, 0, 0, $width, $height, $color);
        $this->writeTextToResource($resource,$text_new,0,0);
        return new Image($resource);
    }


    private function createText($text,$width){
        $font = $this->getFont();
        $font_size = $this->getSize();
        $angle = $this->getAngle();
        $font_path = $font->getPath();

        $text_a = explode(' ', $text);
        $text_new = '';
        foreach($text_a as $word){
            //Create a new text, add the word, and calculate the parameters of the text
            $box = imagettfbbox($font_size, $angle, $font_path, $text_new.' '.$word);
            //if the line fits to the specified width, then add the word with a space, if not then add word with new line
            if($box[2] > $width - $this->getMargin()*2){
                $text_new .= "\n".$word;
            } else {
                $text_new .= " ".$word;
            }
        }
        return trim($text_new);
    }

    private function writeTextToResource($resource,$textModified,$x,$y){
        $font = $this->getFont();
        $clr = $this->getColor();

        $color = imagecolorallocatealpha($resource, $clr->getR(), $clr->getG(), $clr->getB(), $clr->getAlpha());
        $font_path = $font->getPath();
        $font_size = $this->getSize();
        $margin = $this->getMargin();
        $angle = $this->getAngle();

        imagettftext(
            $resource,
            $font_size,
            $angle,
            $x+$margin,
            $y+$font_size+$margin,
            $color,
            $font_path,
            $textModified
        );
    }
}