<?php

use Illuminate\Support\Facades\Route;
use Inventas\AppleMaps\Tests\TestCase;

use function Pest\Laravel\getJson;

afterEach(function () {
    TestCase::$routes = null;
});

it('registers the HTTP routes by default', function () {
    expect(Route::has('api.v1.apple-maps.token'))->toBeTrue()
        ->and(Route::has('api.v1.apple-maps.geocode'))->toBeTrue()
        ->and(Route::has('api.v1.apple-maps.annotation.preview'))->toBeTrue();
});

it('does not register the HTTP routes when they are turned off', function () {
    TestCase::$routes = false;
    $this->refreshApplication();

    expect(Route::has('api.v1.apple-maps.token'))->toBeFalse()
        ->and(Route::has('api.v1.apple-maps.geocode'))->toBeFalse()
        ->and(Route::has('api.v1.apple-maps.annotation.preview'))->toBeFalse();

    getJson('/api/v1/apple-maps/geocode?q=Berlin')->assertNotFound();
});
