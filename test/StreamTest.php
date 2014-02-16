<?php

require dirname(__FILE__) . "/../src/Streams/Stream.php";

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
}
