<?php

namespace Streams\Interfaces;

interface NumericStreamer extends Streamer
{
    public function max();
    public function min();
    public function of();
}
