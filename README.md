Streams
=======
[![Build Status](https://travis-ci.org/pepegar/streams-php.png?branch=master)](https://travis-ci.org/pepegar/streams-php)

Streams is a port of the Streams library for PHP. It makes working with
collections super pleasant.

An example with the Yii ActiveRecord lib:

```php
<?php

use Streams as S;

$collection = Car::model()->findAll(); // Returns an array of Car objects
$carStream = new S\Stream($collection);

$newCollection = $carStream
    ->filter(function( $car ) {
		return ($car->price > 36000); // return only expensive cars!
	})->map(function( $car ) {
		$car->setCo2EmissionTaxes(20); // Since is an expensive car, lets make the people who drive it more poor :D
		return $car;
	})->getElements();
```

Available functions
-------------------
Even though this library is under active development, the currently available
methods are:

###map(callable $callback)
As in every functional programming language, map takes a function as argument
and applies it to each element in the array, returning a new array with the
results.

###filter(callable $callback)
takes a function as argument and applies it to each element in the collection.
It returns a new collection containing all elements where the callback returned
true.

###allMatch(callable $predicate)
returns wether all the elements in the stream match the given predicate

###anyMatch(callable $predicate)
returns wether any the elements in the stream match the given predicate

###concat(Stream $a, Stream $b)
Creates a lazily concatenated stream whose elements are all the elements of the
first stream followed by all the elements of the second stream.
