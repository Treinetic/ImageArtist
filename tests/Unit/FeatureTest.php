<?php

namespace Tests\Unit;

use Tests\TestCase;
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Layers\Layer;
use Treinetic\ImageArtist\Layers\Workspace;
use Treinetic\ImageArtist\Text\TextBox;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;

class FeatureTest extends TestCase
{
    private $testImagePath;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a temporary blank image for testing
        $this->testImagePath = __DIR__ . '/../../test_feature_source.png';
        $img = imagecreatetruecolor(100, 100);
        imagefilledrectangle($img, 0, 0, 100, 100, imagecolorallocate($img, 255, 0, 0));
        imagepng($img, $this->testImagePath);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testImagePath)) {
            unlink($this->testImagePath);
        }
    }

    public function test_can_apply_filters()
    {
        $image = new Image($this->testImagePath);
        // Test chainability and execution
        $image->filter(IMG_FILTER_GRAYSCALE)
            ->filter(IMG_FILTER_BRIGHTNESS, 10);

        $this->assertTrue(true, "Filter methods executed without exception");
        $this->assertInstanceOf(Image::class, $image);
    }

    public function test_layer_system_flattening()
    {
        $workspace = new Workspace(200, 200);

        $layer1 = new Layer(new Image($this->testImagePath), 0, 0);
        $layer2 = new Layer(new Image($this->testImagePath), 50, 50);
        $layer2->setOpacity(50);

        $workspace->addLayer($layer1);
        $workspace->addLayer($layer2);

        $finalImage = $workspace->flatten();

        $this->assertInstanceOf(Image::class, $finalImage);
        $this->assertEquals(200, $finalImage->getWidth());
        $this->assertEquals(200, $finalImage->getHeight());
    }

    public function test_text_box_creation()
    {
        $img = new Image($this->testImagePath);
        $box = new TextBox(100, 20);
        $box->setText("Hello");
        $box->setSize(20);
        $box->setColor(new Color(255, 255, 255));

        // Just verify method call works (no crash)
        $box->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
        $img->setTextBox($box, 0, 0);

        $this->assertTrue(true);
    }
}
