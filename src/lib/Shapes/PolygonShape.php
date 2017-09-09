<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 11:15 AM
 */

namespace Treinetic\ImageArtist\lib\Shapes;


use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Image;

class PolygonShape extends Image implements Shapable
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

    public function build()
    {
        if(count($this->nodes) == 0){
            $this->setDefaults();
        }
        $buffer = 100;
        $width = $this->getWidth();
        $height = $this->getHeight();

        $points = $this->nodeToArray($buffer);
        $num_points = count($this->nodes);
        $image = $this->resizeCropPolygonImage($this->getResource(), $width,$height, $points, $num_points,$buffer);
        $this->setResource($image);
        $image = $this->crop($buffer,$buffer,$width,$height);
        $this->setResource($image->getResource());
    }

    public function nodeToArray($buffer)
    {
        $aray = [];
        $width = $this->getWidth();
        $height = $this->getHeight();
        /* @var Node $node */
        foreach ($this->nodes as $node) {
            $x = 0;
            $y = 0;
            if($node->getMetrics() == Node::$PERCENTAGE_METRICS){
                $x = ($node->getX() * $width)/100.0;
                $y = ($node->getY() * $height)/100.0;
            }else{
                $x = $node->getX();
                $y = $node->getY();
            }
            $aray[] = $x+$buffer;
            $aray[] = $y+$buffer;
        }
        return $aray;
    }

    protected function point($x,$y,$presentage = false){
        $node = new Node($x,$y);
        if($presentage){
            $node->setMetrics(Node::$PERCENTAGE_METRICS);
        }
        $this->push($node);
    }

    private function resizeCropPolygonImage($srcImage, $width, $height, $points, $numPoints,$buffer = 2)
    {
        $bufferdWidth = $width+($buffer * 2);
        $bufferdHeight = $height+($buffer * 2);
        /*
         * we are creating a polygon mask and finally we are merging that mask on top of the
         * source image
         * */
        $maskPolygon = imagecreate($bufferdWidth, $bufferdHeight);
        imagesavealpha( $maskPolygon, true );
        $borderColor = imagecolorallocate($maskPolygon, 1, 254, 255); // fill it with an uncommon color so that we can later delete it
        $transparency = imagecolortransparent($maskPolygon, imagecolorallocate($maskPolygon, 0, 0, 0));
        imagefilledpolygon($maskPolygon, $points, $numPoints, $transparency);

        $copy = imagecreatetruecolor($bufferdWidth, $bufferdHeight);
        $borderColor2 = imagecolorallocate($copy, 1, 254, 255);
        imagesavealpha( $copy, true );
        imagefill($copy, 0, 0, $borderColor2);
        imagecopy($copy, $srcImage, $buffer, $buffer, 0, 0, $width, $height);
        // Apply the mask
        imagecopymerge($copy, $maskPolygon, 0, 0, 0, 0,$bufferdWidth, $bufferdHeight, 100);

        // Make the the border transparent (we're assuming there's a 2px buffer on all sides)
        $borderRGB = imagecolorsforindex($copy, $borderColor);
        $borderTransparency = imagecolorallocatealpha($copy, $borderRGB['red'], $borderRGB['green'], $borderRGB['blue'], 127);
        imagefill($copy, 0, 0, $borderTransparency);

        imagedestroy($maskPolygon);
        imagedestroy($srcImage);

        return $copy;

    }

    function setDefaults()
    {
        //there is no default configuration for this
    }
}