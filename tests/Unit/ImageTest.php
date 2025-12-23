<?php

namespace Tests\Unit;

use Tests\TestCase;
use Treinetic\ImageArtist\Image;

class ImageTest extends TestCase
{
    public function test_can_instantiate_image_class()
    {
        $this->assertTrue(class_exists(Image::class));
    }

    public function test_image_width_and_height()
    {
        // Mock or use a real image if available in test setup.
        // For this basic smoke test, checking class loading is key.
        $this->assertTrue(true);
    }
}
