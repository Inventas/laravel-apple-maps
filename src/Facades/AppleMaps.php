<?php

namespace Inventas\AppleMaps\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inventas\AppleMaps\AppleMaps
 */
class AppleMaps extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Inventas\AppleMaps\AppleMaps::class;
    }
}
