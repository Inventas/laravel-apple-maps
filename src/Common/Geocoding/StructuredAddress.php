<?php

namespace Inventas\AppleMaps\Common\Geocoding;

use Spatie\LaravelData\Data;

class StructuredAddress extends Data
{
    public function __construct(
        public ?string $administrativeArea,
        public ?string $administrativeAreaCode,
        public ?array $areasOfInterest,
        public ?array $dependentLocalities,
        public ?string $fullThoroughfare,
        public string $locality,
        public ?string $postCode,
        public ?string $subLocality,
        public ?string $subThoroughfare,
        public ?string $thoroughfare,
    ) {}
}
