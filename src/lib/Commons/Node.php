<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 9/6/17
 * Time: 11:20 AM
 */

namespace Treinetic\ImageArtist\lib\Commons;


class Node
{

    private $x;
    private $y;
    private $metrics;

    public static $PERCENTAGE_METRICS = "%";
    public static $PIXEL_METRICS = "px";

    /**
     * @return mixed
     */

    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * @param mixed $metrics
     */
    public function setMetrics($metrics)
    {
        $this->metrics = $metrics;
    }

    public function __construct($x,$y, $metrics = null)
    {
        $this->x = $x;
        $this->y = $y;
        $this->metrics = is_null($metrics) ? self::$PIXEL_METRICS : $metrics;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    

}