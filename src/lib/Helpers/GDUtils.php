<?php
/**
 * Created by PhpStorm.
 * User: imal
 * Date: 9/24/17
 * Time: 11:22 PM
 */

namespace Treinetic\ImageArtist\lib\Helpers;


class GDUtils
{
    private static $gdInfo = null;

    private static function getGDInfo()
    {
        if(self::$gdInfo == null){
            self::$gdInfo = gd_info();
        }
        return self::$gdInfo;
    }


    public static function getGDVersion()
    {
        $re = '/\((.*?)\s/';
        $gdinfo = self::getGDInfo();
        $version = $gdinfo["GD Version"];

        if (floatval($version) != 0) {
            return floatval($version);
        }

        preg_match_all($re, $version, $matches, PREG_SET_ORDER, 0);
        return doubleval($matches[0][1]);
    }

    public static function pointsToCurrentGDSupportedMetrics($points){
        $gdVersion = self::getGDVersion();
        if($gdVersion >= 2){
            return $points;
        }
        return self::pointsToPixels($points);
    }

    public static function pointsToPixels($pixels){
        return $pixels / (0.75);
    }
}