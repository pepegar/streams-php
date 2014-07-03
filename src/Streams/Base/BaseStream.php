<?php

namespace Streams\Base;

use Streams\Interfaces;
use Streams as S;

/**
 * BaseStream
 *
 * @uses Streamer
 * @package pepegar/streams-php
 * @version 0.1
 * @copyright Copyright (C) 2014 Pepe García
 * @author Pepe García <jl.garhdez@gmail.com>
 * @license MIT
 */
abstract class BaseStream implements Interfaces\Streamer
{
    /**
     * elements the elements over which the stream will operate
     *
     * @var array
     */
    private $elements;

    /**
     * __construct
     *
     * Constructor of the class.
     *
     * @param array $elements
     * @return void
     */
    public function __construct( array $elements )
    {
        $this->elements = $elements;
    }

    /**
     * map a function to each element in a collection
     *
     * @param $callback
     * @return void
     */
    public function map( $callback )
    {
        $elements = array_map($callback, $this->elements);
        return $this->newStream($elements);
    }

    /**
     * forEachElement
     *
     * This method is intended for containing the side effects, in case you need
     * them. (I am not able to call it foreach because is a reserved keyword)
     *
     * @param $callback
     * @return void
     */
    public function forEachElement( $callback )
    {
        array_map($callback, $this->elements);
        return $this;
    }

    /**
     * filter
     *
     * @param $callback
     * @return void
     */
    public function filter( $callback )
    {
        $elements = array_values(array_filter($this->elements, $callback));
        return $this->newStream($elements);
    }

    /**
     * count
     *
     * returns the count of elements in the stream
     *
     * @return integer
     */
    public function count()
    {
        return count($this->getElements());
    }

    /**
     * distinct
     *
     * returns a new stream consisting of the distinct elements of the stream
     *
     * @return void
     */
    public function distinct()
    {
        $elements = array_unique($this->getElements());
        return $this->newStream($elements);
    }

    /**
     * allMatch
     *
     * returns wether all the elements in the stream match the given
     * predicate
     *
     * @param $callback
     * @return void
     */
    public function allMatch( $callback )
    {
        $prevLength = count($this->getElements());
        return count(array_filter($this->getElements(), $callback)) == $prevLength;
    }

    /**
     * anyMatch
     *
     * returns wether any of the elements in the stream match the given
     * predicate
     *
     * @param $callback
     * @return void
     */
    public function anyMatch( $callback )
    {
        return 0 < (count(array_filter($this->elements, $callback)));
    }

    /**
     * mapToFloat
     *
     * @param $callback
     * @return LongStream
     */
    public function mapToFloat( $callback )
    {
        $this->map($callback);
        return new S\FloatStream($this->getElements());
    }

    /**
     * mapToInt
     *
     * @param $callback
     * @return void
     */
    public function mapToInt( $callback )
    {
        $this->map($callback);
        return new S\IntStream($this->getElements());
    }

    /**
     * concat
     *
     * Creates a lazily concatenated stream whose elements are all the elements
     * of the first stream followed by all the elements of the second stream.
     *
     * @param Stream $a
     * @param Stream $b
     * @return Stream
     */
    public static function concat( S\Stream $a, S\Stream $b )
    {
        $items = $a->getElements() + $b->getElements();
        return new S\Stream($items);
    }

    /**
     * emptyStream
     *
     * returns an empty Stream
     *
     * @return Streamer
     */
    public function emptyStream()
    {
        return $this->newStream(array());
    }

    /**
     * getElements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * setElements
     *
     * @param array $elements
     * @return void
     */
    public function setElements( array $elements )
    {
        $this->elements = $elements;
    }

    /**
     * reduce
     *
     * This operation performs a reduction on the elements of the stream. The
     * first param is used as the initial element for the 
     *
     * @param mixed $initial
     * @param $callback
     * @return mixed
     */
    public function reduce( $initial, $callback )
    {
        return array_reduce($this->elements, $callback, $initial);
    }

    public function newStream( array $elements )
    {
        $class = get_called_class();
        return new $class($elements);
    }
}
