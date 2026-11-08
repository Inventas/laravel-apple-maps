<?php

use Inventas\AppleMaps\AppleMapsServiceProvider;
use Inventas\AppleMaps\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/**
 * Enable the package's HTTP routes the way an application does, through config and the service provider.
 */
function enableAppleMapsRoutes(): void
{
    config(['apple-maps.routes' => true]);

    app()->getProvider(AppleMapsServiceProvider::class)->packageBooted();
    app('router')->getRoutes()->refreshNameLookups();
}
