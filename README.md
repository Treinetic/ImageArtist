# ImageArtist 2.0.0

ImageArtist is a modern PHP library for easy image manipulation using the GD extension. Think of it as a fluent, cleaner API for GD.

This project is an initiative of Treinetic (Pvt) Ltd, Sri Lanka.

![Issues](https://img.shields.io/github/issues/Treinetic/ImageArtist.svg?style=flat-square)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
![Forks](https://img.shields.io/github/forks/Treinetic/ImageArtist.svg?style=flat-square)
![Stars](https://img.shields.io/github/stars/Treinetic/ImageArtist.svg?style=flat-square)

## Requirements

- PHP 8.2 or higher
- `ext-gd` extension

**Optional**:
- `ext-imagick` (Required for advanced features in future versions)

## Installation

Install the package via composer:

```bash
composer require treinetic/imageartist
```

## Usage

### Basic Usage

First, import the necessary classes. **Note**: The namespace has been streamlined to `Treinetic\ImageArtist`.

```php
use Treinetic\ImageArtist\Image;

// Load an image
$image = new Image("./morning.jpeg");

// Scale to 40%
$image->scale(40);

// Resize to specific dimensions
$image->resize(1024, 768);

// Save or Output
$image->save("./newImage.jpg", IMAGETYPE_PNG);
```

### Shape & Attributes

```php
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Shapes\Triangle;
use Treinetic\ImageArtist\Commons\Node;

// Create a Triangle from an image
$triangle = new Triangle("./city.jpg");
$triangle->scale(60);
// Set points (Percentage or Pixels)
$triangle->setPointA(20, 20, true);
$triangle->setPointB(80, 20, true);
$triangle->setPointC(50, 80, true);
$triangle->build();

$triangle->save("./triangle.png", IMAGETYPE_PNG);
```

### Advanced Merging & Overlays

```php
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Overlays\Overlay;
use Treinetic\ImageArtist\Shapes\CircularShape;
use Treinetic\ImageArtist\Text\TextBox;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;

$img = new Image("./background.jpg");

// Add an overlay
$overlay = new Overlay($img->getWidth(), $img->getHeight(), new Color(0, 0, 0, 80));
$img->merge($overlay, 0, 0);

// Add a circular profile picture
$circle = new CircularShape("./person.jpg");
$circle->build();
$img->merge($circle, ($img->getWidth() - $circle->getWidth()) / 2, ($img->getHeight() - $circle->getHeight()) / 2);

// Add Text
$textBox = new TextBox(310, 40);
$textBox->setColor(new Color(255, 255, 255)); // White
$textBox->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
$textBox->setSize(20);
$textBox->setText("We Are Team Treinetic");

$img->setTextBox($textBox, ($img->getWidth() - $textBox->getWidth()) / 2, $img->getHeight() * (5/7));

$img->dump(); // Output directly to browser
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Imal Hasaranga Perera](https://github.com/imalhasaranga)
- [Nuwan Chamara](https://github.com/nuwanchamara)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
