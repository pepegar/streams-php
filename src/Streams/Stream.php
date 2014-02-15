<?php

namespace Streams;

/**
 * Stream
 *
 * @package Streams
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
     * @param Callable $callback 
     * @return void
     */
    public function map( $callback ) {
        $this->elements = array_map($callback, $this->elements);
        return $this;
    }

    public function filter( $callback )
    {
        $this->elements = array_values(array_filter($this->elements, $callback));
        return $this;
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
