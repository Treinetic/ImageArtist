<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 11:15 AM
 */

namespace App\lib;


class Shape extends Image
{

    private $nodes = [];

    public function __construct($image)
    {
        parent::__construct($image);

    }


    public function push(Node $node)
    {
        $this->nodes[] = $node;
    }

    public function pushPresentage(Node $node)
    {
        $node->setMetrics("%");
        $this->nodes[] =$node;
    }

    public function build()
    {
        $points = $this->nodeToArray();
        $num_points = count($this->nodes);
        $image = $this->getResource();
        $image = $this->resizeCropPolygonImage($image, $this->getWidth(), $this->getHeight(), $points, $num_points);
        $this->setResource($image);
    }

    public function nodeToArray()
    {
        $aray = [];
        $width = $this->getWidth();
        $height = $this->getHeight();
        /* @var Node $node */
        foreach ($this->nodes as $node) {
            if($node->getMetrics() == "%"){
                $aray[] = ($node->getX() * $width)/100.0;
                $aray[] = ($node->getY() * $height)/100.0;
            }else{
                $aray[] = $node->getX();
                $aray[] = $node->getY();
            }
        }
        return $aray;
    }

    private function resizeCropPolygonImage($srcImage, $width, $height, $points, $numPoints)
    {

        imagealphablending($srcImage, true);
        imagesavealpha($srcImage, true);
        /*
         * we are creating a polygon mask and finally we are merging that mask on top of the
         * source image
         * */
        $maskPolygon = imagecreate($width, $height);
        $borderColor = imagecolorallocatealpha($maskPolygon, 255, 255, 255, 127);
        $transparency = imagecolortransparent($maskPolygon, imagecolorallocatealpha($maskPolygon, 255, 255, 255, 127));
        imagefilledpolygon($maskPolygon, $points, $numPoints, $transparency);

        // Apply the mask
        imagecopymerge($srcImage, $maskPolygon, 0, 0, 0, 0, $width, $height, 100);


        // Make the the border transparent (we're assuming there's a 2px buffer on all sides)
        $borderRGB = imagecolorsforindex($srcImage, $borderColor);
        $borderTransparency = imagecolorallocatealpha($srcImage, $borderRGB['red'], $borderRGB['green'], $borderRGB['blue'], 127);
        imagesavealpha($srcImage, true);
        imagealphablending($srcImage, true);
        imagefill($srcImage, 0, 0, $borderTransparency);

        imagedestroy($maskPolygon);
        return $srcImage;

    }

}