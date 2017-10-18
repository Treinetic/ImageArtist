# ImageArtist 1.0.0

ImageArtist is a php gd Wrapper which makes Image manipulation insanely easy, we introduce ImageArtist as Photoshop for php 

This project is an initiative of Treinetic (Pvt) Ltd, Sri Lanka. Contact us via info@treinetic.com and get your project done by the experts.


![Issues](https://img.shields.io/github/issues/Treinetic/ImageArtist.svg)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
![Forks](https://img.shields.io/github/forks/Treinetic/ImageArtist.svg)
![Stars](https://img.shields.io/github/stars/Treinetic/ImageArtist.svg)
![Twitter](https://img.shields.io/twitter/url/https/github.com/Treinetic/ImageArtist.svg?style=social)


## Requirements

PHP 5.0 >

**Optional** ( Consider installing imagick along with pango for complex unicode Texts )
- [Imageick](http://php.net/manual/en/book.imagick.php) with [Pango](http://www.pango.org/)

## Install

The package can be installed via composer:
``` bash
$ composer require treinetic/imageartist
```

## Usage ( Let's Dive In )

### Very Basics

* Load Image, Most of the Classes Extends the Image class so if you know how to load an Image then you know how to use most of the library classes

```php
$image = new Image("./morning.jpeg");
```
**Note :** Remember to import ( use ) the class first, see demo folder for more complete code.

* Image Resizing

```php
$image->scale(40); //scales the image 40%
$image->scaleToHeight(1024); //scales the image keeping height 1024
$image->scaleToWidth(1024); //scales the image keeping width 1024
$image->resize(1024,768); //resizes the image to a given size 

```

* Image Attributes

```php
$new_wdith = $image->getWidth();
$new_height = $image->getHeight();
```

* Change Format/ Save to Disk
```php
$image->convertTo(IMAGETYPE_PNG);
$image->save("./newImage.jpg",IMAGETYPE_PNG);
```

* Orientation
```php
$image->rotate(50); 
$image->flipV(); // Vertical Flip
$image->flipH(); // Horizontal Flip
```


* Other Usefull Operations
```php
$base64URL = $image->getDataURI();
/* 
    Image class will return itself for following methods but in Shape classes it will be a new Image 
    to keep the idea of Shape Consistant
 */
$image->crop(100,100,300,300);
$image->merge(new Image("./city.jpg"),10,10);
```

### Awesome Stuff
**Lets do some things that matter**

* **Create a shape**, for creating a custom shape you can directly use Either `CircularShape.php` or `PolygonShape.php` however if you are looking for a standard shape which is not yet existing then still you can use either `CircularShape.php` or `PolygonShape.php` to create them but we encorage you to contribute to the project by adding those shape
* Lets Create a **Triangle** ( There are few other Pre made shapes for your use )

```php
$triangle = new Triangle("./city.jpg");
$triangle->scale(60);
$triangle->setPointA(20,20,true); //setting point A, i'm using preentages but you can use px as well
$triangle->setPointB(80,20,true);
$triangle->setPointC(50,80,true);
$triangle->build();
```

<p align="center">
  <img width="400" src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/triangle.png"/>
</p>

* Create **Create Custom Shape**, lets see how we can make a nice Pentagon

```php
$pentagon = new PolygonShape("./morning.jpeg");
$pentagon->scale(60);
$pentagon->push(new Node(50,0, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(75,50, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(62.5,100, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(37.5,100, Node::$PERCENTAGE_METRICS));
$pentagon->push(new Node(25,50, Node::$PERCENTAGE_METRICS));
$pentagon->build();
```
<p align="center">
<img width="400" src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/polygon.png"/>
</p>

* Lets **Merge Two Triangles** 

```php
$tr1 = new Triangle("./city.jpg");
$tr1->scale(60);
$tr1->setPointA(0,0,true);
$tr1->setPointB(100,0,true);
$tr1->setPointC(100,100,true);
$tr1->build();

$tr2 = new Triangle("./morning.jpeg");
$tr2->scale(60);
$tr2->setPointA(0,0,true);
$tr2->setPointB(0,100,true);
$tr2->setPointC(100,100,true);
$tr2->build();

$tr1->resize($tr1->getWidth(),$tr2->getHeight());

$img = $tr1->merge($tr2,0,0);
$img->scale(70);
```

<p align="center">
<img src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/merge.png"/>
</p>

* Let's Do Some Photoshop Shall we ? **Create a Facebook cover**
 
```php
/* Let's add an overlay to this */
$overlay = new Overlay($img->getWidth(),$img->getHeight(),new Color(0,0,0,80));
$img->merge($overlay,0,0);
/* hmmm.. lets add a photo */
$circle = new CircularShape("./person.jpg");
$circle->build();
$img = $img->merge($circle,($img->getWidth()-$circle->getWidth())/2,($img->getHeight() - $circle->getHeight())/2);
/* I think I should add some Text */
$textBox = new TextBox(310,40);
$textBox->setColor(Color::getColor(Color::$WHITE));
$textBox->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
$textBox->setSize(20);
$textBox->setMargin(2);
$textBox->setText("We Are Team Treinetic");
$img->setTextBox($textBox,($img->getWidth()-$textBox->getWidth())/2,$img->getHeight()* (5/7));

$img->dump(); //development purposes only
```

<p align="center">
<img src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/cover.png"/>
</p>


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Imal Hasaranga Perera](https://github.com/imalhasaranga)
- [Nuwan Chamara](https://github.com/nuwanchamara)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
