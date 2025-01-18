<?php

namespace Inventas\AppleMaps\Common\Geocoding;

use Spatie\LaravelData\Data;
use Stringable;

class SearchLocation extends Data implements Stringable
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {}

    public function __toString(): string
    {
        return "{$this->latitude},{$this->longitude}";
    }

    public function toString(): string
    {
        return $this->__toString();
    }
}
