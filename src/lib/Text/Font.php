<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/7/17
 * Time: 6:35 PM
 */

namespace Treinetic\ImageArtist\lib\Text;


use Treinetic\ImageArtist\lib\AssetManager\Asset;

class Font
{
    private $font_path;

    public static $NOTOSERIF_REGULAR = "NotoSerif-Regular.ttf";
    public static $NOTOSERIF_ITALIC = "NotoSerif-Italic.ttf";
    public static $NOTOSERIF_BOLDITALIC = "NotoSerif-BoldItalic.ttf";
    public static $NOTOSERIF_BOLD = "NotoSerif-Bold.ttf";
    public static $NOTOSANS_SINHALA_REGULAR = "NotoSerif-Bold.ttf";
    public static $ISKOLA_POTA = "iskoola-pota.ttf";

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