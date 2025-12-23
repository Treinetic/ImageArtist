# Shapes in ImageArtist

ImageArtist provides a powerful set of Shape classes that allow you to crop images into various geometric forms (Circles, Polygons, Triangles) or create standalone shapes.

> [!NOTE]
> All shapes in ImageArtist are extensions of the `Image` class. This means you can perform all standard image operations (scale, rotate, merge) on any shape!

## Available Shapes

- **CircularShape**: Crop images into circles or ellipses.
- **PolygonShape**: Create custom polygons with any number of points.
- **Triangle**: Special case of Polygon for 3-sided shapes.
- **Square**: Simple rectangular/square crops.

## 1. CircularShape

The `CircularShape` class allows you to crop an image into a circle or an ellipse.

### Usage

```php
use Treinetic\ImageArtist\Shapes\CircularShape;

$circle = new CircularShape("./images/face.jpg");
// The build() method processes the crop
$circle->build(); 

$circle->save("./output/face_circle.png", IMAGETYPE_PNG);
```

### Advanced Usage (Ellipses & Offsets)

You can define the center and major/minor axes to create specific circular crops.

```php
$circle = new CircularShape("./images/landscape.jpg");
// Set center to (100, 100)
$circle->setCenter(100, 100);
// Set dimensions (Major Axis, Minor Axis) basically Radius X and Radius Y
$circle->setAxises(50, 50);

$circle->build();
```

> [!IMPORTANT]
> As of **v2.1.0**, CircularShape uses **Supersampling (2x)** to produce high-quality antialiased edges, removing the jagged "staircase" effect seen in older versions.

## 2. PolygonShape

The `PolygonShape` allows for creating custom shapes by defining a series of points (Nodes).

### Usage

```php
use Treinetic\ImageArtist\Shapes\PolygonShape;
use Treinetic\ImageArtist\Commons\Node;

$pentagon = new PolygonShape("./texture.jpg");
$pentagon->scale(60);

// Add Points (Nodes)
// Node($x, $y) - You can use Node::$PERCENTAGE_METRICS to use % values
$pentagon->push(new Node(50, 0, Node::$PERCENTAGE_METRICS));   // Top
$pentagon->push(new Node(100, 38, Node::$PERCENTAGE_METRICS)); // Right Top
$pentagon->push(new Node(81, 100, Node::$PERCENTAGE_METRICS)); // Right Bottom
$pentagon->push(new Node(19, 100, Node::$PERCENTAGE_METRICS)); // Left Bottom
$pentagon->push(new Node(0, 38, Node::$PERCENTAGE_METRICS));   // Left Top

$pentagon->build();
$pentagon->save("pentagon.png", IMAGETYPE_PNG);
```

<p align="center">
<img width="300" src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/polygon.png"/>
</p>

## 3. Triangle

A helper class specifically for Triangles.

```php
use Treinetic\ImageArtist\Shapes\Triangle;

$triangle = new Triangle("./city.jpg");
$triangle->setPointA(50, 0, true);   // Top Middle (Percentage=true)
$triangle->setPointB(100, 100, true); // Bottom Right
$triangle->setPointC(0, 100, true);   // Bottom Left

$triangle->build();
```

<p align="center">
  <img width="300" src="https://raw.githubusercontent.com/Treinetic/ImageArtist/images/img/triangle.png"/>
</p>
