<?php
namespace Treinetic\ImageArtist\lib\AssetManager;
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:38 PM
 */
class Asset
{
    private static $asset;

    private function __construct()
    {
    }

    public static function getAssetInstance(){
        if(self::$asset == null){
            self::$asset = new Asset();
        }
        return self::$asset;
    }

    public function getBasePath(){
        return __DIR__."/../../resources";
    }

    public function getAsset($name){
        return $this->getBasePath()."/".$name;
    }

    public function getFontAsset($name){
        return $this->getBasePath()."/Fonts/".$name;
    }
}