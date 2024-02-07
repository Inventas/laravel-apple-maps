<?php

namespace Inventas\AppleMaps\Common\Geocoding;

use Spatie\LaravelData\Data;

class TokenResponse extends Data
{
    public function __construct(
        public string $accessToken,
        public int $expiresInSeconds
    ) {

    }
}
