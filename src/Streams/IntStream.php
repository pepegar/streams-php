<?php

namespace Streams;

use Streams\Base;

/**
 * IntStream
 *
 * @uses Streams\Base\NumericStream
 * @package pepegar/streams-php
 * @version 0.1
 * @copyright Copyright (C) 2014 Pepe García
 * @author Pepe García <jl.garhdez@gmail.com>
 * @license MIT
 */
class IntStream extends Base\NumericStream
{
    public function __construct( array $elements )
    {
        $this->setElements(array_map(function($item) {
            return (int) $item;
        }, $elements));
        return $this;
    }
}
