# ImageArtist 2.0.0

ImageArtist is a modern PHP library for easy image manipulation using the GD extension. Think of it as a fluent, cleaner API for GD. It simplifies complex tasks like shapes, text overlays, and merging.

This project is an initiative of Treinetic (Pvt) Ltd, Sri Lanka.

![Issues](https://img.shields.io/github/issues/Treinetic/ImageArtist.svg?style=flat-square)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
![Forks](https://img.shields.io/github/forks/Treinetic/ImageArtist.svg?style=flat-square)
![Stars](https://img.shields.io/github/stars/Treinetic/ImageArtist.svg?style=flat-square)
![Twitter](https://img.shields.io/twitter/url/https/github.com/Treinetic/ImageArtist.svg?style=social)

## Features

| Feature | Description |
| :--- | :--- |
| **Fluent API** | Chained methods for intuitive image manipulation (`scale()->crop()->save()`). |
| **Shapes** | Built-in support for Triangles, Polygons, Circles, and Squares. |
| **Text Overlays** | Add multi-line text with custom fonts, colors, and positioning. |
| **Smart Merging** | Merge multiple images, shapes, or overlays with alpha blending support. |
| **Geometric Helpers** | Easy coordinate and size calculations. |
| **Zero Dependencies** | Lightweight, relying primarily on the standard GD extension. |

## Requirements

- PHP 8.2 or higher
- `ext-gd` extension

**Optional**:
- `ext-imagick` (Required for advanced features in future versions)

## Installation

### 1. System Dependencies

This library requires the **GD Extension** enabled in your environment.

**Docker (Dockerfile)**
```dockerfile
RUN docker-php-ext-install gd
```

**Ubuntu / Debian**
```bash
sudo apt-get install php-gd
```

**Alpine Linux**
```bash
apk add php-gd
```

### 2. Composer

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

> [!TIP]
> **New:** Detailed documentation and examples for all shapes are available in only [docs/shapes.md](docs/shapes.md).

```php
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Shapes\Triangle;
use Treinetic\ImageArtist\Commons\Node;

// Create a Triangle from an image
$triangle = new Triangle("./city.jpg");
// ... rest of the example
```

```php
$triangle->scale(60);
// Set points (Percentage or Pixels)
$triangle->setPointA(20, 20, true);
$triangle->setPointB(80, 20, true);
$triangle->setPointC(50, 80, true);
$triangle->build();

$triangle->save("./triangle.png", IMAGETYPE_PNG);
```

<p align="center">
  <img width="400" src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/triangle.png"/>
</p>

### Advanced Merging & Overlays

```php
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Overlays\Overlay;
use Treinetic\ImageArtist\Shapes\CircularShape;
use Treinetic\ImageArtist\Text\TextBox;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;

$img = new Image("./background.jpg");
// ... rest of the example
```

```php
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

<p align="center">
<img src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/cover.png"/>
</p>

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Imal Hasaranga Perera](https://github.com/imalhasaranga)
- [Nuwan Chamara](https://github.com/nuwanchamara)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
