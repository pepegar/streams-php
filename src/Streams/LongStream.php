<?php

namespace Streams;

use Streams\Base;

/**
 * LongStream 
 * 
 * @uses Streams\Base\NumericStream
 * @package pepegar/streams-php
 * @version 0.1
 * @copyright Copyright (C) 2014 Pepe García
 * @author Pepe García <jl.garhdez@gmail.com> 
 * @license MIT
 */
class LongStream extends Base\NumericStream
{
    /**
     * concat
     *
     * @param LongStream $a
     * @param LongStream $b
     * @return Streamer
     */
    public static function concat( LongStream $a, LongStream $b )
    {
        return parent::concat();
    }
}
