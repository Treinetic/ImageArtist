# ImageArtist 0.0.2-alpha
ImageArtist is a php gd Wrapper which makes Image manipulation insanely easy, we introduce ImageArtist as Photoshop for php 

This project is an initiative of [Treinetic (Pvt) Ltd](http://www.treinetic.com), Sri Lanka.


## Requirements

PHP 5.0 >

## Install

The package can be installed via composer:
``` bash
$ composer require treinetic/imageartist
```

## Usage ( Let's Dive In )

###Very Basics

* Load Image, Mostely of the Classes Extends the Image class so if you know how to load an Image then you know how to use most of the library classes

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

* Change Format, Save to Disk
```php
$image->convertTo(IMAGETYPE_PNG);
$image->save("./newImage.jpg",IMAGETYPE_PNG);
```

* Other Usefull Operations
```php
$base64URL = $image->getBase64URL();
/* 
    Image class will return itself for following methods but in Shape classes it will be a new Image 
    to keep the idea of Shape Consistant
 */
$image->crop(100,100,300,300);
$image->merge(new Image("https://drive.google.com/file/d/0B3zA54ciopGBN3FkanVkbS1sdk0/view?usp=sharing"),10,10);
```

###Awesome Stuff
Lets do some things that matter

* Create a shape, for creating a custom shape you can directly use Either `CircularShape.php` or `PolygonShape.php` however if you are looking for a standard shape which is not yet created then still you can use either `CircularShape.php` or `PolygonShape.php` to create them but we encorage you to contribute to the project by adding that shape
* Create **Triangle**

```php
$triangle = new Triangle("./city.jpg");
$triangle->scale(60);
$triangle->setPointA(20,20,true); //setting point A, i'm using preentages but you can use px as well
$triangle->setPointB(80,20,true);
$triangle->setPointC(50,80,true);
$triangle->build();
```
![alt text](https://lh4.googleusercontent.com/z7OA1LTz7b3y4kDbpuSuQ-44wphOOzdqe169qzXlesdQStr9VrfQeHt_HOKmycSsPx-ox8UaKMPajXg=w1615-h960-rw)


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