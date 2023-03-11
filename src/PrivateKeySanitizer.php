<?php

namespace Inventas\AppleMaps;

class PrivateKeySanitizer
{
    public static function sanitize(string $privateKey): string
    {
        return str_replace('\\n', "\n", $privateKey);
    }
}
