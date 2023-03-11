<?php

namespace Inventas\AppleMaps\Common\Geocoding;

use Spatie\LaravelData\Data;

class ErrorResponse extends Data
{
    public function __construct(
        public string $message,
        public array $details = [],
    ) {
    }
}
