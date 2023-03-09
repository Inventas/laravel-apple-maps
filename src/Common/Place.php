<?php

namespace Inventas\AppleMaps\Common;

use Spatie\LaravelData\Data;

class Place extends Data
{
    public function __construct(
        public string $country,
        public string $countryCode,
        public MapRegion $displayMapRegion,
        public array $formattedAddressLines,
        public string $name,
        public Location $coordinate,
        public StructuredAddress $structuredAddress,
    ) {
    }
}
