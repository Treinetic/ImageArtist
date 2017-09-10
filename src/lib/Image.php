<?php

namespace Treinetic\ImageArtist\lib;
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
    private $type;

    public function __construct($image)
    {
        $this->resource = $this->getImage($image,function ($type) {
            $this->type = $type;
        });
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

    public function merge(Image $image,$pos_x, $pos_y){
        $width = $this->getWidth();
        $height = $this->getHeight();
        $mergeImage = imagecreatetruecolor($width, $height);
        imagealphablending($mergeImage, true);
        imagesavealpha($mergeImage, true);
        imagecopyresampled($mergeImage, $this->getResource(), 0, 0, 0, 0, $width, $height, $width, $height);
        imagecopy($mergeImage,$image->getResource(),$pos_x,$pos_y,0,0,$width, $height); //($mergeImage, $image->getResource(), $pos_x, $pos_y, 0, 0, $width, $height, $image->getWidth(), $image->getHeight());
        imagedestroy($this->getResource());
        $this->setResource($mergeImage);
        return $this;
    }

    public function crop($x,$y,$width,$height){
        $resource = imagecrop($this->getResource(), ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
        imagedestroy($this->getResource());
        $this->setResource($resource);
        return $this;
    }

    public function getBase64URL($type=IMAGETYPE_PNG){
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
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->resource, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->resource = $new_image;
    }

    public function scale($presentage){
        $width = $this->getWidth() * $presentage/100;
        $height = $this->getHeight() * $presentage/100;
        $this->resize($width,$height);
    }

    public function setTextBox(TextBox $textBox,$x,$y,$draw_rect =false){
        $textBox->write($this->getResource(),$x,$y,$textBox->getWidth(),$textBox->getHeight());
        if($draw_rect){
            $pink = imagecolorallocate($this->getResource(), 255, 105, 180);
            imagerectangle($this->getResource(), $x, $y, $x+$textBox->getWidth(), $y+$textBox->getHeight(), $pink);
        }
    }

    /*
     * This method is debugging purposes only
     * */
    public function dump(){
        $url = $this->getBase64URL(IMAGETYPE_PNG);
        echo "<body ><img src='$url' /></body>";
    }

    private function getImage($data,$otherInfo)
    {
        if (is_string($data)) {
            $info = getimagesize($data);
            $type = $info[2];
            $otherInfo($type);
            if ($type == IMAGETYPE_JPEG) {
                return imagecreatefromjpeg($data);
            } else if ($type == IMAGETYPE_GIF) {
                return imagecreatefromgif($data);
            } else {
                return imagecreatefrompng($data);
            }
        } else if ($data instanceof Image) {
            $type = $data->getType();
            $otherInfo($type);
            $copy = imagecreatetruecolor($data->getWidth(), $data->getHeight());
            return imagecopy($copy, $data->getResource(), 0, 0, 0, 0, $data->getWidth(), $data->getHeight());
        } else {
            return $data;
        }
    }


}