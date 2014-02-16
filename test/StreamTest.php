<?php

//require dirname(__FILE__) . "/../src/Streams/Stream.php";

use Streams as S;

/**
 * StreamTest
 *
 * @uses PHPUnit_Framework_TestCase
 * @package pepegar/streams-php
 * @version 0.1
 * @copyright Copyright (C) 2014 Pepe García
 * @author Pepe García <jl.garhdez@gmail.com>
 * @license MIT
 */
class StreamTest extends PHPUnit_Framework_TestCase
{
    private $array = array(1, 2, 3, 4);

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
        $this->assertEquals(array(2,4,6,8), $stream->getElements());

        $stream
            ->map($callback)
            ->map($callback);
        $this->assertEquals(array(8, 16, 24, 32), $stream->getElements());
    }

    public function testFilter()
    {
        $stream = new S\Stream($this->array);

        $predicate = function($item) {
            return !($item % 2);
        };

        $stream->filter($predicate);
        $this->assertEquals(array(2, 4), $stream->getElements());

        $stream = new S\Stream($this->array);

        $predicateEven = function($item) {
            return !($item % 2);
        };

        $predicateEqualsFour = function($item) {
            return $item == 4;
        };

        $stream->filter($predicateEven)->filter($predicateEqualsFour);
        $this->assertEquals(array(4), $stream->getElements());
    }

    public function testNestedMapAndFilterCallsWorksAsExpected()
    {
        $stream = new S\Stream($this->array);

        $stream
            ->map(function ($item) {
                return $item * 3;
            })->filter(function ($item) {
                return $item % 6 == 0;
            });

        $this->assertEquals($stream->getElements(), array(6, 12));
    }

    public function testAllMatch()
    {
        $stream = new S\Stream(array(2,4,6,8));

        $result = $stream->allMatch(function($item) {
            return !($item % 2);
        });

        $this->assertEquals(true, $result);
    }

    public function testAnyMatch()
    {
        $stream = new S\Stream($this->array);

        $result = $stream->anyMatch(function($item) {
            return !($item % 3);
        });

        $this->assertTrue($result);
    }

    public function testConcatStreams()
    {
        $streamA = new S\Stream($this->array);
        $streamB = new S\Stream($this->array);
        $newStream = S\Stream::concat($streamA, $streamB);

        $this->assertInstanceOf('Streams\Base\BaseStream', $newStream);

        $this->assertEquals($newStream->getElements(), $streamA->getElements() + $streamB->getElements());
    }

    public function testCount()
    {
        $stream = new S\Stream($this->array);

        $this->assertEquals(4, $stream->count());
    }

    public function testDistinct()
    {
        $stream = new S\Stream([1,2,3,4,1,2,3,4,1,2,3,4,1,2,3,4]);
        $newStream = $stream->distinct();
        $this->assertInstanceOf('Streams\Stream', $newStream);

        $this->assertEquals($newStream->getElements(), [1,2,3,4]);

        $stream = new S\Stream([4,5,6,7,4,5,6,7]);
        $newStream = $stream->distinct();
        $this->assertInstanceOf('Streams\Stream', $newStream);

        $this->assertEquals($newStream->getElements(), [4,5,6,7]);
    }
}
