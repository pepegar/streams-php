Streams
=======
[![Build Status](https://travis-ci.org/pepegar/streams-php.png?branch=master)](https://travis-ci.org/pepegar/streams-php)
[![License](https://poser.pugx.org/pepegar/streams-php/license.png)](https://packagist.org/packages/pepegar/streams-php)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b4707079-cd47-4d91-b0c2-92e8b92b5f21/big.png)](https://insight.sensiolabs.com/projects/b4707079-cd47-4d91-b0c2-92e8b92b5f21)

Streams is a port of the Streams library for PHP. It makes working with
collections super pleasant.

Installation
------------
Just add the following to your `composer.json` file:
```json
"pepegar/streams-php": "dev-master"
```


Usage
-----
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

###count()
returns the count of elements in the stream

###distinct()
returns a new stream consisting of the distinct elements of the stream

Hacking
-------
Please, submit your Pull Requests, and make sure that the build passes.
