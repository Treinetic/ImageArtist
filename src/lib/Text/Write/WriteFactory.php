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
    public static $GD_WRITING_STRAT = "gd";
    public static $IMAGICK_WRITING_STRAT = "imagick";

    public static function getWriteStrategy(){
        if(is_null(self::$writeStrategy)){
            if(extension_loaded('imagick')){
                return new ImagickWritingStrategy();
            }else{
                return new GDWritingStrategy();
            }
        }else{
            switch (self::$writeStrategy){
                case self::$IMAGICK_WRITING_STRAT :
                    return new ImagickWritingStrategy();
                case self::$GD_WRITING_STRAT :
                    return new GDWritingStrategy();
            }
        }
    }


    /*
     * @Param string $strategy can have imagick | gd as the value or keep auto pass null
     * */
    public static function overrideWriteStrategySelection($strategy){
        if(!in_array($strategy,[self::$IMAGICK_WRITING_STRAT, self::$GD_WRITING_STRAT])){
            throw new \Exception("invalid argument provided \$strategy variable only support for [ 'gd','imagick' ] ");
        }
        self::$writeStrategy = $strategy;
    }

}