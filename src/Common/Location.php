<?php

namespace Inventas\AppleMaps\Common;

use Spatie\LaravelData\Data;

class Location extends Data
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
    }
}
