<?php

namespace Inventas\AppleMaps\Common\Geocoding;

use Spatie\LaravelData\Data;

class MapRegion extends Data
{
    public function __construct(
        public float $eastLongitude,
        public float $northLatitude,
        public float $southLatitude,
        public float $westLongitude,
    ) {}
}
