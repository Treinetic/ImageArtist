<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:35 PM
 */

namespace App\lib\Text;


use App\lib\AssetManager\Asset;

class Font
{
    private $font_path;

    public static $CODE2002 = "CODE2002.TTF";

    public function __construct($font_path)
    {
        $this->font_path = $font_path;
    }

    public static function getFont($font_name_hash)
    {
        $asset = Asset::getAssetInstance();
        return new Font($asset->getFontAsset($font_name_hash));
    }

    public function getPath(){
        return $this->font_path;
    }
}