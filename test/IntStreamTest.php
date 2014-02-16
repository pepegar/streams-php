<?php

use Streams as S;

class IntStreamTest extends PHPUnit_Framework_TestCase
{
    private $array = [1,2,3,4,5,6,7,8,9,10];

    public function testConstruct()
    {
        $intStream = new S\IntStream($this->array);
        $this->assertInstanceOf('Streams\IntStream', $intStream);
    }

    public function testMax()
    {
        $intStream = new S\IntStream($this->array);
        $max = $intStream->max();

        $this->assertEquals(10, $max);
    }

    public function testMin()
    {
        $intStream = new S\IntStream($this->array);
        $min = $intStream->min();

        $this->assertEquals(1, $min);
    }

    public function testOf()
    {
        $intStream = new S\IntStream($this->array);
        $newStream = $intStream->of(3,4,5);

        $this->assertInstanceOf('Streams\IntStream', $newStream);
        $this->assertEquals([3,4,5], $newStream->getElements());
    }
}
