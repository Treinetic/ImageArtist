<?php
namespace Treinetic\ImageArtist\lib\Text\Write;
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/12/17
 * Time: 10:18 AM
 */
class WriteFactory
{

    public static function getWriteStrategy(){
        if(extension_loaded('imagick')){
            return new ImagickWritingStrategy();
        }else{
            return new GDWritingStrategy();
        }
    }

}