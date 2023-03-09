<?php

namespace Inventas\AppleMaps\Common;

use Spatie\LaravelData\Data;

class TokenResponse extends Data
{
    public string $accessToken;
    public int $expiresInSeconds;
}
