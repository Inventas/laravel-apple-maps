<?php

namespace Inventas\AppleMaps\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Inventas\AppleMaps\AppleMaps
 *
 * @see \Inventas\AppleMaps\AppleMaps
 */
class AppleMaps extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Inventas\AppleMaps\AppleMaps::class;
    }
}
