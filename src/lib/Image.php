<?php

namespace Treinetic\ImageArtist\lib;
use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Commons\Rectangle;
use Treinetic\ImageArtist\lib\Helpers\ImageHelper;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Text\Font;
use Treinetic\ImageArtist\lib\Text\TextBox;

/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 10:55 AM
 */
class Image
{

    private $resource;
    protected $imageHelper;

    public function __construct($image)
    {
        $this->imageHelper = new ImageHelper();
        $this->resource = $this->getImage($image);
    }

    public function __destruct()
    {
        if (is_resource($this->getResource()))
        {
            imagedestroy($this->getResource());
        }
    }


    public function getResource()
    {
        return $this->resource;
    }

    public function getType(){
        return $this->type;
    }

    protected function setResource($resource){
        $this->resource = $resource;
    }

    public function getWidth(){
        return imagesx($this->resource);
    }

    public function getHeight(){
        return imagesy($this->resource);
    }

    /*-----------------------------------------------*/

    public function merge(Image $image,$pos_x, $pos_y){
        $currentImageBoundry = new Rectangle(new Node(0,0),new Node($this->getWidth(),$this->getHeight()));
        $secondImageAfterPlacedBoundry = new Rectangle(new Node($pos_x,$pos_y), new Node($image->getWidth()+$pos_x,$image->getHeight()+$pos_y));

        if($currentImageBoundry->isFullyOutsideOf($secondImageAfterPlacedBoundry)){
            imagesavealpha($this->getResource(),true);
            imagesavealpha($image->getResource(),true);
            imagecopy($this->getResource(), $image->getResource(), $pos_x, $pos_y, 0, 0, $image->getWidth(), $image->getHeight());
        }else{
            $boundryRectangle = Rectangle::createBoundryRectangle($currentImageBoundry,$secondImageAfterPlacedBoundry);
            $currentImageBoundry = $boundryRectangle->createRelativeRectangle($currentImageBoundry);
            $secondImageAfterPlacedBoundry = $boundryRectangle->createRelativeRectangle($secondImageAfterPlacedBoundry);

            $copy = imagecreatetruecolor($boundryRectangle->getWidth(), $boundryRectangle->getHeight());
            $template = $this->imageHelper->createTransparentTemplate($boundryRectangle->getWidth(),$boundryRectangle->getHeight());
            imagecopy($template, $this->getResource(), $currentImageBoundry->getA()->getX(), $currentImageBoundry->getA()->getY(), 0, 0, $this->getWidth(), $this->getHeight());
            imagecopy($template, $image->getResource(), $secondImageAfterPlacedBoundry->getA()->getX(), $secondImageAfterPlacedBoundry->getA()->getY(), 0, 0, $image->getWidth(), $image->getHeight());
            imagedestroy($this->getResource());
            $this->setResource($template);
        }

        return $this;
    }

    public function rotate($degrees){
        $pngTransparency = imagecolorallocatealpha( $this->getResource() , 0, 0, 0, 127 );
        $resource = imagerotate($this->getResource(), $degrees, $pngTransparency);
        imagedestroy($this->getResource());
        $this->setResource($resource);
        return $this;
    }

    public function flipV(){
        imageflip($this->getResource(), IMG_FLIP_VERTICAL);
        return $this;
    }

    public function flipH(){
        imageflip($this->getResource(), IMG_FLIP_HORIZONTAL);
        return $this;
    }

    public function crop($x,$y,$width,$height){
        $resource = imagecrop($this->getResource(), ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
        imagedestroy($this->getResource());
        $this->setResource($resource);
        return $this;
    }

    /*----------------------------------------------------------------*/

    public function getDataURI($type=IMAGETYPE_PNG){
        ob_start();
        $this->convertTo($type);
        $base64 = base64_encode(ob_get_clean());
        $mime_type = image_type_to_mime_type ($type);
        return "data:$mime_type;base64,$base64";
    }

    /*
     * $compression is only for jpeg
     *  */
    public function save($filename, $type=IMAGETYPE_JPEG, $compression=75) {
        if( $type == IMAGETYPE_JPEG ) {
            imagejpeg($this->resource,$filename,$compression);
        } elseif( $type == IMAGETYPE_GIF ) {
            imagegif($this->resource,$filename);
        } elseif( $type == IMAGETYPE_PNG ) {
            imagepng($this->resource,$filename);
        }
    }

    public function convertTo($type=IMAGETYPE_JPEG){
        if( $type == IMAGETYPE_JPEG ) {
            imagejpeg($this->resource);
        } elseif( $type == IMAGETYPE_GIF ) {
            imagegif($this->resource);
        } elseif( $type == IMAGETYPE_PNG ) {
            imagepng($this->resource);
        }
    }

    public function scaleToWidth($width){
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize($width,$height);
    }
    public function scaleToHeight($height){
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }

    public function resize($width,$height){
        $new_image = $this->imageHelper->createTransparentTemplate($width,$height);
        imagecopyresampled($new_image, $this->resource, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->resource = $new_image;
    }

    public function scale($presentage){
        $width = $this->getWidth() * $presentage/100;
        $height = $this->getHeight() * $presentage/100;
        $this->resize($width,$height);
    }

    public function setTextBox(TextBox $textBox,$x,$y,$draw_rect =false){
        $textBox->write($this,$x,$y);
        if($draw_rect){
            $pink = imagecolorallocate($this->getResource(), 255, 105, 180);
            imagerectangle($this->getResource(), $x, $y, $x+$textBox->getWidth(), $y+$textBox->getHeight(), $pink);
        }
    }

    /*
     * This method is debugging purposes only
     * */
    public function dump($color = ''){
        $url = $this->getDataURI(IMAGETYPE_PNG);
        echo "<body style='background:$color' ><img src='$url' /></body>";
    }

    private function getImage($data)
    {
        if (is_string($data)) {
            $info = getimagesize($data);
            $type = $info[2];
            if ($type == IMAGETYPE_JPEG) {
                return imagecreatefromjpeg($data);
            } else if ($type == IMAGETYPE_GIF) {
                return imagecreatefromgif($data);
            } else {
                return imagecreatefrompng($data);
            }
        } else {
            $resource = $data;
            if ($data instanceof Image) {
                $resource = $data->getResource();
            }
            $width = imagesx($resource);
            $height =imagesy($resource);
            $copy = $this->imageHelper->createTransparentTemplate($width,$height);
            imagecopy($copy,$resource , 0, 0, 0, 0, $width, $height);
            return $copy;
        }
    }




}