<?php

namespace Treinetic\ImageArtist\Layers;

use Treinetic\ImageArtist\Image;

class Workspace
{
    private $width;
    private $height;
    private $layers = [];

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function addLayer(Layer $layer)
    {
        $this->layers[] = $layer;
    }

    public function flatten()
    {
        // Create base canvas
        $canvas = imagecreatetruecolor($this->width, $this->height);

        // Transparent Background
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $this->width, $this->height, $transparent);
        imagealphablending($canvas, true); // Enable blending for layers

        $baseImage = new Image($canvas);

        foreach ($this->layers as $layer) {
            /** @var Layer $layer */
            if (!$layer->isVisible()) {
                continue;
            }

            // Merge logic
            // Since ImageArtist::merge changes the image destructively, 
            // and we want $baseImage to accumulate changes.
            // But Layer opacity handling is not natively supported in Image::merge directly with a simple parameter
            // We might need to handle specific opacity merging here or update Image::merge.

            // For now, let's use the Image::merge but if Layer has opacity < 100, we need to handle it.
            // The Image::merge method signature is merge(Image $to_merge, $x, $y).
            // It uses imagecopymerge which supports 'pct' (percentage) as the last arg.
            // But we don't have access to modify Image::merge's internal call easily unless we change Image class 
            // or do manual merging here using resource.

            // Basic Implementation:
            $srcRes = $layer->getImage()->getResource();
            $dstRes = $baseImage->getResource();

            $w = $layer->getImage()->getWidth();
            $h = $layer->getImage()->getHeight();

            imagecopymerge(
                $dstRes,
                $srcRes,
                $layer->getX(),
                $layer->getY(),
                0,
                0,
                $w,
                $h,
                $layer->getOpacity()
            );
        }

        return $baseImage;
    }
}
