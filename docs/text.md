# Text in ImageArtist

Adding text to images is a core feature of ImageArtist. You can control the font, size, color, angle, and position of text using the `TextBox` class.

## Basic Usage

To add text, you create a `TextBox` object and then apply it to the `Image` using `setTextBox`.

```php
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Text\TextBox;
use Treinetic\ImageArtist\Text\Color;
use Treinetic\ImageArtist\Text\Font;

$img = new Image("photo.jpg");

// 1. Create a TextBox (Width, Height)
$box = new TextBox(300, 50);

// 2. Configure Text Properties
$box->setColor(new Color(255, 255, 255)); // RGB White
$box->setFont(Font::getFont(Font::$NOTOSERIF_BOLD));
$box->setSize(20); // Font size in pts
$box->setText("Hello World");

// 3. Place on Image (X, Y)
$img->setTextBox($box, 100, 100);

$img->save("output.jpg", IMAGETYPE_JPEG);
```

## Fonts

ImageArtist comes with a set of bundled **Google Noto** fonts, but you can use any `.ttf` file.

### Built-in Fonts
- `Font::$NOTOSERIF_REGULAR`
- `Font::$NOTOSERIF_ITALIC`
- `Font::$NOTOSERIF_BOLD`
- `Font::$NOTOSERIF_BOLDITALIC`

### Custom Fonts
You can load a custom font by providing the absolute path to the `.ttf` file.

```php
$customFont = new Font("/path/to/MyCustomFont.ttf");
$box->setFont($customFont);
```

## Colors

Colors can be defined using RGB or RGBA (Alpha/Transparency).

```php
// Solid Red
$red = new Color(255, 0, 0);

// Semi-transparent Black (Overlay style)
$shadow = new Color(0, 0, 0, 50); 
```

## TextBox Positioning

Calculing the center position is a common requirement.

```php
// Center the text horizontally
$x = ($img->getWidth() - $box->getWidth()) / 2;
// Center the text vertically
$y = ($img->getHeight() - $box->getHeight()) / 2;

$img->setTextBox($box, $x, $y);
```
