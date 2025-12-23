# Filters & Effects

ImageArtist supports applying standard image filters to your images directly.

## Usage

Use the `filter()` method with standard PHP GD filter constants.

```php
use Treinetic\ImageArtist\Image;

$img = new Image("photo.jpg");

// Grayscale
$img->filter(IMG_FILTER_GRAYSCALE);

// Brightness (Level -255 to 255)
$img->filter(IMG_FILTER_BRIGHTNESS, 50);

// Contrast (Level -100 to 100)
$img->filter(IMG_FILTER_CONTRAST, -20);

// Gaussian Blur
$img->filter(IMG_FILTER_GAUSSIAN_BLUR);

// Pixelate (Block Size, Advanced)
$img->filter(IMG_FILTER_PIXELATE, 5, true);

$img->save("filtered.jpg");
```

## Available Filters

- `IMG_FILTER_NEGATE`: Rejects all colors of the image.
- `IMG_FILTER_GRAYSCALE`: Converts the image into grayscale.
- `IMG_FILTER_BRIGHTNESS`: Changes the brightness of the image.
- `IMG_FILTER_CONTRAST`: Changes the contrast of the image.
- `IMG_FILTER_COLORIZE`: Like IMG_FILTER_GRAYSCALE, except you can specify the color.
- `IMG_FILTER_EDGEDETECT`: Uses edge detection to highlight the edges in the image.
- `IMG_FILTER_EMBOSS`: Embosses the image.
- `IMG_FILTER_GAUSSIAN_BLUR`: Blurs the image using the Gaussian method.
- `IMG_FILTER_SELECTIVE_BLUR`: Blurs the image.
- `IMG_FILTER_MEAN_REMOVAL`: Uses mean removal to achieve a "sketchy" effect.
- `IMG_FILTER_SMOOTH`: Makes the image smoother.
- `IMG_FILTER_PIXELATE`: Applies pixelation effect to the image.
