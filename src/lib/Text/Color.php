<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:15 PM
 */

namespace Treinetic\ImageArtist\lib\Text;


class Color
{
    private $R;
    private $G;
    private $B;
    private $Alpha;

    public static $WHITE = "WHITE";
    public static $PURPLE = "PURPLE";
    public static $DARKPINK = "DARKPINK";

    /*
     * alpha goes 0-127  (0 -> fully visible, 127 -> fully transparent )
     * */
    public function __construct($R,$G,$B,$Alpha = 0)
    {
        $this->R = $R;
        $this->G = $G;
        $this->B = $B;
        $this->Alpha = $Alpha;
    }

    public static function getColor($color_const){
        switch ($color_const){
            case self::$WHITE:
                return new Color(255,255,255);
                break;
            case self::$PURPLE:
                return new Color(128,0,128);
                break;
            case self::$DARKPINK:
                return new Color(255,20,147);
                break;
        }
    }

    public function toString(){

        $val = 1 -($this->getAlpha()/127);
        return "rgba(".$this->R.", ".$this->G.", ".$this->B.", $val)";
    }

    /**
     * @return mixed
     */
    public function getR()
    {
        return intval($this->R);
    }

    /**
     * @return mixed
     */
    public function getG()
    {
        return intval($this->G);
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return intval($this->B);
    }

    /**
     * @return int
     */
    public function getAlpha()
    {
        return $this->Alpha;
    }

    

}