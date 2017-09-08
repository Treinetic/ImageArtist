<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 14:42
 */


use App\lib\CircleShape;

require('vendor/autoload.php');

$circileShape = new CircleShape("ttt.jpg");
$circileShape->build();
$circileShape->dump();
//$circileShape->save("res.png",IMAGETYPE_PNG);