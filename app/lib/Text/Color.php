<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:15 PM
 */

namespace App\lib\Text;


class Color
{
    private $R;
    private $G;
    private $B;
    private $Alpha;

    public static $WHITE = "WHITE";

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
        }
    }

    /**
     * @return mixed
     */
    public function getR()
    {
        return $this->R;
    }

    /**
     * @return mixed
     */
    public function getG()
    {
        return $this->G;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->B;
    }

    /**
     * @return int
     */
    public function getAlpha()
    {
        return $this->Alpha;
    }

    

}