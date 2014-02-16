<?php

namespace Streams\Base;

use Streams\Interfaces;

class NumericStream extends BaseStream implements Interfaces\NumericStreamer
{
    public function max()
    {
        return max($this->getElements());
    }

    public function min()
    {
        return min($this->getElements());
    }

    public function of()
    {
        $args = func_get_args();
        $this->filter(function($item) use($args) {
            return in_array($item, $args);
        });
        return $this;
    }
}
