<?php
/**
 * Created by PhpStorm.
 * User: Nuwan
 * Date: 08/09/2017
 * Time: 10:56
 */

require('../vendor/autoload.php');

require ('./CircleShape.php');

$circileShape=new \test\CircleShape("ttt.jpg");
//$circileShape->build();
//$circileShape->dump();
//$circileShape->display();

$circileShape->crop()->display();
$circileShape->build();
$circileShape->dump();
//$circileShape->save("res.png",IMAGETYPE_PNG);