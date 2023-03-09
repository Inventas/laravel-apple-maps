<?php

namespace Inventas\AppleMaps\Requests;

use Inventas\AppleMaps\Common\SearchLocation;
use Inventas\AppleMaps\Common\SearchRegion;
use Spatie\LaravelData\Data;

class GeocodeQuery extends Data
{
    public function __construct(
        public string $q,
        public array $limitToCountries = [],
        public string $lang = 'en-US',
        public ?SearchLocation $searchLocation = null,
        public ?SearchRegion $searchRegion = null,
        public ?SearchLocation $userLocation = null,
    ) {
    }
}
