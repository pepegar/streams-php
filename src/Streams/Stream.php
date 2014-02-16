<?php

namespace Streams;

/**
 * Stream
 *
 * @package pepegar/streams-php
 * @version 0.1
 * @copyright Copyright (C) 2014 Pepe García
 * @author Pepe García <jl.garhdez@gmail.com>
 * @license MIT
 */
class Stream
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
     * map funcnti
     *
     * @param callable $callback
     * @return void
     */
    public function map( callable $callback )
    {
        $this->elements = array_map($callback, $this->elements);
        return $this;
    }

    /**
     * forEachElement
     *
     * This method is intended for containing the side effects, in case you need
     * them. (I am not able to call it foreach because is a reserved keyword)
     *
     * @param callable $callback
     * @return void
     */
    public function forEachElement( callable $callback )
    {
        array_map($callback, $this->elements);
        return $this;
    }

    /**
     * filter
     *
     * @param callable $callback
     * @return void
     */
    public function filter( callable $callback )
    {
        $this->elements = array_values(array_filter($this->elements, $callback));
        return $this;
    }

    /**
     * allMatch
     *
     * returns wether all the elements in the stream match the
     * given predicate
     *
     * @param callable $callback
     * @return void
     */
    public function allMatch( callable $callback )
    {
        $prevLength = count($this->getElements());
        return count(array_filter($this->getElements(), $callback)) == $prevLength;
    }

    /**
     * anyMatch
     *
     * returns wether any of the elements in the stream match the
     * given predicate
     *
     * @param callable $callback
     * @return void
     */
    public function anyMatch( callable $callback )
    {
        return 0 < (count(array_filter($this->elements, $callback)));
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
}
