<?php

use Illuminate\Support\Facades\Route;
use Inventas\AppleMaps\Tests\TestCase;

use function Pest\Laravel\getJson;

afterEach(function () {
    TestCase::$routes = null;
});

it('does not register the HTTP routes by default', function () {
    expect(Route::has('api.v1.apple-maps.token'))->toBeFalse()
        ->and(Route::has('api.v1.apple-maps.geocode'))->toBeFalse()
        ->and(Route::has('api.v1.apple-maps.annotation.preview'))->toBeFalse();

    getJson('/api/v1/apple-maps/token')->assertNotFound();
    getJson('/api/v1/apple-maps/geocode?q=Berlin')->assertNotFound();
});

it('registers the HTTP routes when enabled', function () {
    TestCase::$routes = true;
    $this->refreshApplication();

    expect(Route::has('api.v1.apple-maps.token'))->toBeTrue()
        ->and(Route::has('api.v1.apple-maps.geocode'))->toBeTrue()
        ->and(Route::has('api.v1.apple-maps.annotation.preview'))->toBeTrue();
});
