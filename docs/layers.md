# Layer System (v2.1+)

The Layer System allows for non-destructive editing by stacking multiple images on a workspace and flattening them at the end.

## Usage

```php
use Treinetic\ImageArtist\Image;
use Treinetic\ImageArtist\Layers\Layer;
use Treinetic\ImageArtist\Layers\Workspace;

// 1. Create a Workspace (Canvas)
$workspace = new Workspace(800, 600);

// 2. Create Layers
$bgLayer = new Layer(new Image("background.jpg"), 0, 0);
$fgLayer = new Layer(new Image("logo.png"), 50, 50);

// Adjust Layer Properties
$fgLayer->setOpacity(80); // 80% Opacity

// 3. Add to Workspace
$workspace->addLayer($bgLayer);
$workspace->addLayer($fgLayer);

// 4. Flatten to get a final Image
$finalImage = $workspace->flatten();

$finalImage->save("composition.png", IMAGETYPE_PNG);
```
