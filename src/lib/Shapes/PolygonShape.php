<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 11:15 AM
 */

namespace Treinetic\ImageArtist\lib\Shapes;


use Treinetic\ImageArtist\lib\Commons\Node;
use Treinetic\ImageArtist\lib\Commons\Rectangle;

class PolygonShape extends Shape implements Shapable
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
        $boundingRectangle = Rectangle::findBoundingRectangle($this->nodeToFixedNodeArray(0));
        $image = imagecrop($image, ['x' => $buffer+$boundingRectangle->getA()->getX(), 'y' => $buffer+$boundingRectangle->getA()->getY(), 'width' => $boundingRectangle->getWidth(), 'height' => $boundingRectangle->getHeight()]);
        imagedestroy($this->getResource());
        $this->setResource($image);
    }

    public function nodeToArray($buffer)
    {
        $aray = [];
        $width = $this->getWidth();
        $height = $this->getHeight();
        /* @var Node $node */
        foreach ($this->nodes as $node) {
            $node = $this->fixNode($width,$height,$node);
            $aray[] = $node->getX()+$buffer;
            $aray[] = $node->getY()+$buffer;
        }
        return $aray;
    }

    public function nodeToFixedNodeArray($buffer){
        $aray = [];
        $width = $this->getWidth();
        $height = $this->getHeight();
        /* @var Node $node */
        foreach ($this->nodes as $node) {
            $node = $this->fixNode($width,$height,$node);
            $node->setX($node->getX()+$buffer);
            $node->setY($node->getY()+$buffer);
            $aray[] = $node;
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
         * we are creating a polygon.png mask and finally we are merging that mask on top of the
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

        return $copy;

    }

    private function fixNode($width,$height,Node $node){
        $x = 0;
        $y = 0;
        if($node->getMetrics() == Node::$PERCENTAGE_METRICS){
            $x = ($node->getX() * $width)/100.0;
            $y = ($node->getY() * $height)/100.0;
        }else{
            $x = $node->getX();
            $y = $node->getY();
        }
       return new Node($x,$y);
    }

    function setDefaults()
    {
        //there is no default configuration for this
    }
}