<?php

namespace Inventas\AppleMaps\Common;

class SearchRegion
{

    public function __construct(
        public float $northLatitude,
        public float $eastLongitude,
        public float $southLatitude,
        public float $westLongitude,
    ) {

    }

    public function __toString(): string
    {
        return "$this->northLatitude,$this->eastLongitude,$this->southLatitude,$this->westLongitude";
    }

    public function toString(): string
    {
        return $this->__toString();
    }

}
