<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\Geocoding\SearchLocation;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Requests\ReverseGeocodeRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('it can geocode an address', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::fixture('reverse-geocode.berlin.token'),
        ReverseGeocodeRequest::class => MockResponse::fixture('reverse-geocode.berlin'),
    ]);

    $connector = new AppleMapsConnector();
    $connector->withMockClient($mockClient);
    $request = new ReverseGeocodeRequest(
        location: new SearchLocation(latitude: 52.51626, longitude: 13.37721),
        language: 'de-DE',
    );

//    dd($mockClient);

    $response = $connector->send($request, $mockClient);

    expect($response->status())->toBe(200);

    $response = $response->dto();
    $firstResult = $response->results[0];

    expect($firstResult)
        ->country->toBe('Deutschland');
});
