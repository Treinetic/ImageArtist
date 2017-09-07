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


    protected function push(Node $node)
    {
        $this->nodes[] = $node;
    }

    protected function pushPresentage(Node $node)
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
        /*
           Special thanks to  https://stackoverflow.com/questions/9580239/howto-crop-area-outside-polygon
           Bryce Siedschlaw : https://stackoverflow.com/users/733547/bryce-siedschlaw
           From Imal
           --------------
         */

        $mergeImage = imagecreatetruecolor($width, $height);
        imagealphablending($mergeImage, false);
        imagesavealpha($mergeImage, true);
        imagecopyresampled($mergeImage, $srcImage, 0, 0, 0, 0, $width, $height, imagesx($srcImage), imagesy($srcImage));

        /******** This is probably the part that you're most interested in *******/
        // Create the image we will use for the mask of the polygon shape and
        // fill it with an uncommon color
        $maskPolygon = imagecreate($width, $height);
        imagealphablending($maskPolygon, false);
        imagesavealpha($maskPolygon, true);
        $borderColor = imagecolorallocatealpha($maskPolygon, 255, 255, 255, 0);
        imagefill($maskPolygon, 0, 0, $borderColor);

        // Add the transparent polygon mask
        $transparency = imagecolortransparent($maskPolygon, imagecolorallocatealpha($maskPolygon, 255, 255, 255, 0));
        imagesavealpha($maskPolygon, true);
        imagefilledpolygon($maskPolygon, $points, $numPoints, $transparency);

        // Apply the mask
        imagesavealpha($mergeImage, true);
        imagecopymerge($mergeImage, $maskPolygon, 0, 0, 0, 0, $width, $height, 100);

        /******* Here I am using a custom function to get the outer     *********
         ******* perimeter of the polygon. I'll add this one in below   ********/
        // Crop down to just the polygon area
        $polygonPerimeter = $this->getPolygonCropCorners($points);
        $polygonX = $polygonPerimeter[0]['min'];
        $polygonY = $polygonPerimeter[1]['min'];
        $polygonWidth = $polygonPerimeter[0]['max'] - $polygonPerimeter[0]['min'];
        $polygonHeight = $polygonPerimeter[1]['max'] - $polygonPerimeter[1]['min'];

        // Create the final image
        $destImage = imagecreatetruecolor($polygonWidth, $polygonHeight);
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagecopy($destImage, $mergeImage,
            0, 0,
            $polygonX, $polygonY,
            $polygonWidth, $polygonHeight);

        // Make the the border transparent (we're assuming there's a 2px buffer on all sides)
        $borderRGB = imagecolorsforindex($destImage, $borderColor);
        $borderTransparency = imagecolorallocatealpha($destImage, $borderRGB['red'], $borderRGB['green'], $borderRGB['blue'], 127);
        imagesavealpha($destImage, true);
        imagealphablending($destImage, true);
        imagefill($destImage, 0, 0, $borderTransparency);

        imagedestroy($maskPolygon);
        imagedestroy($srcImage);
        return $destImage;

    }

    private function getPolygonCropCorners($points)
    {
        $perimeter = array();

        for ($i = 0; $i < count($points); $i++) {
            $axisIndex = $i % 2;

            if (count($perimeter) < $axisIndex) {
                $perimeter[] = array();
            }

            $min = isset($perimeter[$axisIndex]['min']) ? $perimeter[$axisIndex]['min'] : $points[$i];
            $max = isset($perimeter[$axisIndex]['max']) ? $perimeter[$axisIndex]['max'] : $points[$i];

            // Adding an extra pixel of buffer
            $perimeter[$axisIndex]['min'] = min($min, $points[$i] - 2);
            $perimeter[$axisIndex]['max'] = max($max, $points[$i] + 2);
        }

        return $perimeter;
    }
}