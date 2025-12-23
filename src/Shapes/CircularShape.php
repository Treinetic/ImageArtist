<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 10:44
 */

namespace Treinetic\ImageArtist\Shapes;


use Treinetic\ImageArtist\Commons\Node;

class CircularShape extends Shape implements Shapable
{


    private $major_axis;// ellipse width
    private $minor_axis;// ellipse height
    /** @var  Node $center */
    private $center; // elipse center

    /**
     *
     * CircleShape constructor.
     */
    public function __construct($image)
    {
        parent::__construct($image);
    }


    public function build()
    {
        // by putting the conditins here as well gives users easily override setDefaults method
        // without worrynig about the conditions
        if (empty($this->major_axis) || empty($this->minor_axis) || empty($this->center)) {
            $this->setDefaults();
        }
        $this->cropCircle();
    }

    /*
     * ( -- major -- \minor    )
     *
     * */
    public function setAxises($major_axis, $minor_axis)
    {
        $this->major_axis = $major_axis;
        $this->minor_axis = $minor_axis;
        return $this;
    }

    public function setCenter($x, $y)
    {
        $this->center = new Node($x, $y);
    }

    private function cropCircle()
    {
        // 1. Setup dimensions (Supersampling 2x for antialiasing)
        $superSampleFactor = 2; // Higher is smoother, 2 is usually sufficient

        $targetWidth = $this->major_axis * 2;
        $targetHeight = $this->minor_axis * 2;

        $superWidth = $targetWidth * $superSampleFactor;
        $superHeight = $targetHeight * $superSampleFactor;

        $pointX = $this->center->getX() - $this->major_axis;
        $pointY = $this->center->getY() - $this->minor_axis;

        // 2. Create the Supersampled Working Canvas
        $workImg = imagecreatetruecolor($superWidth, $superHeight);

        // Enable proper alpha handling for the working canvas
        imagealphablending($workImg, false);
        imagesavealpha($workImg, true);

        // Fill with transparent background
        $transparent = imagecolorallocatealpha($workImg, 255, 255, 255, 127);
        imagefilledrectangle($workImg, 0, 0, $superWidth, $superHeight, $transparent);

        // 3. Copy source image to Working Canvas (Scaled Up)
        // We use imagecopyresampled to copy source -> 2x canvas
        imagecopyresampled(
            $workImg,           // Dest
            $this->getResource(),  // Src
            0,
            0,               // Dst X, Y
            $pointX,
            $pointY,   // Src X, Y
            $superWidth,
            $superHeight, // Dst W, H
            $targetWidth,
            $targetHeight // Src W, H (taking 1:1 from source section)
        );

        // 4. MASKING (at 2x resolution)

        $cutoutMask = imagecreatetruecolor($superWidth, $superHeight);
        $pink = imagecolorallocate($cutoutMask, 255, 0, 255); // Color to be removed (Transparent Key)
        imagefilledrectangle($cutoutMask, 0, 0, $superWidth, $superHeight, $pink);

        $transparentHole = imagecolorallocate($cutoutMask, 0, 0, 0); // Color doesn't matter (Black), represents the Shape
        imagecolortransparent($cutoutMask, $transparentHole); // Define hole as transparent key

        // Anti-alias the shape drawing on the mask
        if (function_exists('imageantialias')) {
            imageantialias($cutoutMask, true);
        }

        imagefilledellipse($cutoutMask, $superWidth / 2, $superHeight / 2, $superWidth, $superHeight, $transparentHole);

        // Merge Cutout onto Work Image
        // This paints "Pink" over everything OUTSIDE the circle.
        imagecopymerge($workImg, $cutoutMask, 0, 0, 0, 0, $superWidth, $superHeight, 100);

        // NOW, make Pink transparent on the Work Image.
        imagecolortransparent($workImg, $pink);


        // 6. Resample Down to Target (This creates the Antialiasing!)
        $finalImg = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($finalImg, false);
        imagesavealpha($finalImg, true);
        $finalTransparent = imagecolorallocatealpha($finalImg, 255, 255, 255, 127);
        imagefilledrectangle($finalImg, 0, 0, $targetWidth, $targetHeight, $finalTransparent);

        imagecopyresampled(
            $finalImg,
            $workImg,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $superWidth,
            $superHeight
        );

        // Cleanup
        imagedestroy($workImg);
        imagedestroy($cutoutMask);
        imagedestroy($this->getResource());

        $this->setResource($finalImg);
        return $this;
    }

    function setDefaults()
    {
        if (empty($this->major_axis) || empty($this->minor_axis)) {
            $this->major_axis = $this->getWidth() / 2;
            $this->minor_axis = $this->getHeight() / 2;
        }
        if (empty($this->center)) {
            $this->center = new Node($this->getWidth() / 2, $this->getHeight() / 2);
        }
    }
}