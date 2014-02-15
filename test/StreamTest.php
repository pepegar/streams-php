<?php

require dirname(__FILE__) . "/../src/Streams/Stream.php";

use Streams as S;

class StreamTest extends PHPUnit_Framework_TestCase
{
    private $array = [1, 2, 3, 4];

    public function testConstructor()
    {
        $stream = new S\Stream($this->array);

        $this->assertTrue($stream instanceof S\Stream);

        $this->assertEquals($this->array, $stream->getElements());
    }

    public function testMap()
    {
        $stream = new S\Stream($this->array);

        $callback = function($item) {
            return $item * 2;
        };

        $stream->map($callback);
        $this->assertEquals([2,4,6,8], $stream->getElements());

        $stream
            ->map($callback)
            ->map($callback);
        $this->assertEquals([8, 16, 24, 32], $stream->getElements());
    }

    public function testFilter()
    {
        $stream = new S\Stream($this->array);

        $predicate = function($item) {
            return !($item % 2);
        };

        $stream->filter($predicate);
        $this->assertEquals([2, 4], $stream->getElements());

        $stream = new S\Stream($this->array);

        $predicateEven = function($item) {
            return !($item % 2);
        };

        $predicateEqualsFour = function($item) {
            return $item == 4;
        };

        $stream->filter($predicateEven)->filter($predicateEqualsFour);
        $this->assertEquals([4], $stream->getElements());
    }
}
