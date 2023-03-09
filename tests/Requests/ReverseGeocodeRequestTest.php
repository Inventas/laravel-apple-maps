<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\SearchLocation;
use Inventas\AppleMaps\Requests\ReverseGeocodeRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

test('it can geocode an address', function () {

    Saloon::fake([
        MockResponse::fixture('geocode.berlin'),
    ]);

    $connector = new AppleMapsConnector();
    $request = new ReverseGeocodeRequest(
        location: new SearchLocation(latitude: 52.51626, longitude: 13.37721),
        language: 'de-DE',
    );

    $response = $connector->send($request);

    expect($response->status())->toBe(200);

    $response = $response->dto();
    $firstResult = $response->results[0];

    expect($firstResult)
        ->country->toBe('Deutschland');
});
