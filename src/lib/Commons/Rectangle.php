<?php
/**
 * Created by PhpStorm.
 * User: imal
 * Date: 9/10/17
 * Time: 9:15 AM
 */

namespace Treinetic\ImageArtist\lib\Commons;


/*     a        b
 *     |--------|
 *     |        |
 *    d|--------|c
 * */

class Rectangle
{
    private $a;
    private $b;
    private $c;
    private $d;

    /**
     * @return Node
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param Node $a
     */
    public function setA($a)
    {
        $this->a = $a;
    }

    /**
     * @return Node
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @param Node $b
     */
    public function setB($b)
    {
        $this->b = $b;
    }

    /**
     * @return Node
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * @param Node $c
     */
    public function setC($c)
    {
        $this->c = $c;
    }

    /**
     * @return Node
     */
    public function getD()
    {
        return $this->d;
    }

    /**
     * @param Node $d
     */
    public function setD($d)
    {
        $this->d = $d;
    }

    public function __construct(Node $a, Node $c)
    {
        $this->a = $a;
        $this->b = new Node($c->getX(), $a->getY());
        $this->c = $c;
        $this->d = new Node($a->getX(), $c->getY());
    }

    /*
     * check if  $rec is fully inside of this rectangle
     * */
    public function isFullyOutsideOf(Rectangle $rec)
    {
        return ($this->getA()->getX() <= $rec->getA()->getX())
            && ($this->getA()->getY() <= $rec->getA()->getY())
            && ($this->getC()->getX() >= $rec->getC()->getX())
            && ($this->getC()->getY() >= $rec->getC()->getY());
    }

    /*
     * takes rectangles and returns a rectangle that is big enough to cover both of them
     * */

    public static function createBoundryRectangle($rc1, $rc2){
        $nodes = array_merge($rc1->getNodes(),$rc2->getNodes());
        return self::findBoundingRectangle($nodes);
    }

    public static function findBoundingRectangle($nodes){
        $nodeA_X = $nodeA_Y = PHP_INT_MAX;
        $nodeC_X = $nodeC_Y = ~PHP_INT_MAX;
        /** @var Node $node */
        for ($i =0; $i < count($nodes); ++$i){
            //find lowest node
            /** @var Node $node */
            $node = $nodes[$i];
            $nodeA_X = $node->getX() <= $nodeA_X ?  $node->getX() : $nodeA_X;
            $nodeA_Y = $node->getY() <= $nodeA_Y ?  $node->getY() : $nodeA_Y;

            //find heighest node
            $nodeC_X = $node->getX() >= $nodeC_X ?  $node->getX() : $nodeC_X;
            $nodeC_Y = $node->getY() >= $nodeC_Y ?  $node->getY() : $nodeC_Y;
        }
       // var_export([ $nodeA_X, $nodeA_Y, $nodeC_X, $nodeC_Y ]);
        return new Rectangle(new Node($nodeA_X,$nodeA_Y), new Node($nodeC_X, $nodeC_Y));
    }

    public function getWidth(){
        return $this->getB()->getX() - $this->getA()->getX();
    }

    public function getHeight(){
        return $this->getC()->getY() - $this->getB()->getY();
    }

    public function normalizeCordinates(){
        if($this->getA()->getX() < 0){
            $x = abs($this->getA()->getX());
            $this->getA()->setX(0);
            $this->getB()->setX($this->getB()->getX()+$x);
            $this->getC()->setX($this->getC()->getX()+$x);
            $this->getD()->setX(0);
        }
        if($this->getA()->getY() < 0){
            $y = abs($this->getA()->getY());
            $this->getA()->setY(0);
            $this->getB()->setY(0);
            $this->getC()->setY($this->getC()->getY()+$y);
            $this->getD()->setY($this->getD()->getY()+$y);

        }
    }

    public function getNodes(){
        return [$this->getA(),$this->getB(),$this->getC()];
    }

    /*
     * to call this you need to be certain that current rectangle is a parent to the
     * rectangle which is passing
     *
     * */
    public function createRelativeRectangle(Rectangle $r){
        $nodeA = new Node($r->getA()->getX()-$this->getA()->getX(),$r->getA()->getY()-$this->getA()->getY() );
        $nodeC = new Node($r->getC()->getX()-$this->getA()->getX(),$r->getC()->getY()-$this->getA()->getY());
        return new Rectangle($nodeA,$nodeC);
    }

}