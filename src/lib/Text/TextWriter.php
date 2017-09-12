<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:12 PM
 */

namespace Treinetic\ImageArtist\lib\Text;


use Treinetic\ImageArtist\lib\Image;
use Treinetic\ImageArtist\lib\Text\Write\GDWritingStrategy;
use Treinetic\ImageArtist\lib\Text\Write\WriteFactory;
use Treinetic\ImageArtist\lib\Text\Write\WritingStrategy;

class TextWriter
{
    private $color;
    private $font;
    private $text;
    private $size;
    private $margin;
    private $angle;
    private $width;
    private $height;

    /** @var  WritingStrategy $write */
    private $write;

    public function __construct($writer_auto_detect = true)
    {
        $this->setAngle(0);
        if($writer_auto_detect){
            $this->write = WriteFactory::getWriteStrategy();
        }else{
            $this->write = new GDWritingStrategy();
        }
        $this->write->setWriter($this);
    }

    public function write(Image $image,$x,$y){
        $new_resource = $this->getImage();
        return $image->merge($new_resource,$x,$y);
    }


    public function getImage(){
        return new Image($this->write->write());
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
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



}