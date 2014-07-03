<?php

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

        $result = $stream->map($callback);
        $this->assertEquals(array(2,4,6,8), $result->getElements());

        $secondResult = $result
            ->map($callback)
            ->map($callback);
        $this->assertEquals(array(8, 16, 24, 32), $secondResult->getElements());
    }

    public function testFilter()
    {
        $stream = new S\Stream($this->array);

        $predicate = function($item) {
            return !($item % 2);
        };

        $result = $stream->filter($predicate);
        $this->assertEquals(array(2, 4), $result->getElements());

        $stream = new S\Stream($this->array);

        $predicateEven = function($item) {
            return !($item % 2);
        };

        $predicateEqualsFour = function($item) {
            return $item == 4;
        };

        $secondResult = $stream->filter($predicateEven)->filter($predicateEqualsFour);
        $this->assertEquals(array(4), $secondResult->getElements());
    }

    public function testNestedMapAndFilterCallsWorksAsExpected()
    {
        $stream = new S\Stream($this->array);

        $result = $stream
            ->map(function ($item) {
                return $item * 3;
            })->filter(function ($item) {
                return $item % 6 == 0;
            });

        $this->assertEquals($result->getElements(), array(6, 12));
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
        $stream = new S\Stream(array(1,2,3,4,1,2,3,4,1,2,3,4,1,2,3,4));
        $newStream = $stream->distinct();
        $this->assertInstanceOf('Streams\Stream', $newStream);

        $this->assertEquals($newStream->getElements(), array(1,2,3,4));

        $stream = new S\Stream(array(4,5,6,7,4,5,6,7));
        $newStream = $stream->distinct();
        $this->assertInstanceOf('Streams\Stream', $newStream);

        $this->assertEquals($newStream->getElements(), array(4,5,6,7));
    }

    public function testMapToFloat()
    {
        $stream = new S\Stream(array(1,2,3,4,1,2,3,4,1,2,3,4,1,2,3,4));
        $newStream = $stream->mapToFloat(function($item) {
            return $item;
        });
        $this->assertInstanceOf('Streams\FloatStream', $newStream);
    }

    public function testMapToInt()
    {
        $stream = new S\Stream(array(1,2,3,4,1,2,3,4,1,2,3,4,1,2,3,4));
        $newStream = $stream->mapToInt(function($item) {
            return $item;
        });
        $this->assertInstanceOf('Streams\IntStream', $newStream);
    }

    public function testReduce()
    {
        $stream = new S\Stream(array(1,2,3,4));
        $sum = $stream->reduce(0, function($item, $next) {
            return $item + $next;
        });
        $this->assertEquals(10, $sum);

        $mult = $stream->reduce(1, function($item, $next) {
            return $item * $next;
        });
        $this->assertEquals(24, $mult);
    }

    public function testLetsDoCoolThingsSuchAsMapReduce()
    {
        $arrayOfPhrases = array(
            'first second third',
            'first second',
            'fourth second fourth',
            'first second second',
            'third second third',
        );

        $phrasesStream = new S\Stream($arrayOfPhrases);

        $computedArray = $phrasesStream
            ->map(function( $line ) {
                return array_count_values(explode(' ', $line));
            })
            ->reduce(array(), function( $acc, $next ) {
                foreach ( $next as $word => $count ) {
                    if ( isset($acc[$word]) )
                        $acc[$word] += $count;
                    else
                        $acc[$word] = $count;
                }

                return $acc;
            });

        $this->assertEquals(3, $computedArray['first']);
        $this->assertEquals(6, $computedArray['second']);
        $this->assertEquals(3, $computedArray['third']);
        $this->assertEquals(2, $computedArray['fourth']);
    }
}
