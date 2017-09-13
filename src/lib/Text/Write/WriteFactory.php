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
    private static $writeStrategy = null;

    public static function getWriteStrategy(){
        if(is_null(self::$writeStrategy)){
            if(extension_loaded('imagick')){
                return new ImagickWritingStrategy();
            }else{
                return new GDWritingStrategy();
            }
        }else{
            switch (self::$writeStrategy){
                case "imagick" :
                    return new ImagickWritingStrategy();
                case "gd" :
                    return new GDWritingStrategy();
            }
        }
    }


    /*
     * @Param string $strategy can have imagick | gd as the value or keep auto pass null
     * */
    public static function overrideWriteStrategySelection($strategy){
        if(!in_array($strategy,["imagick", "gd"])){
            throw new \Exception("invalid argument provided \$strategy variable only support for [ 'gd','imagick' ] ");
        }
        self::$writeStrategy = $strategy;
    }

}