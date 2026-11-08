<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\Geocoding\Place;
use Inventas\AppleMaps\Common\Geocoding\PlaceResults;
use Inventas\AppleMaps\Common\Geocoding\SearchLocation;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Requests\ReverseGeocodeRequest;
use Inventas\AppleMaps\Tests\Support\AppleMapsResponseFactory;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Spatie\LaravelData\DataCollection;

test('it can reverse geocode a location', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::make(AppleMapsResponseFactory::token()),
        ReverseGeocodeRequest::class => MockResponse::make(AppleMapsResponseFactory::placeResults(
            name: 'Ebertstrasse 23',
            latitude: 52.5167025,
            longitude: 13.3778032,
        )),
    ]);

    $connector = new AppleMapsConnector;
    $connector->withMockClient($mockClient);
    $request = new ReverseGeocodeRequest(
        location: new SearchLocation(latitude: 52.51626, longitude: 13.37721),
        language: 'de-DE',
    );

    $response = $connector->send($request, $mockClient);

    expect($response->status())->toBe(200);

    $results = $response->dto();

    expect($results)
        ->toBeInstanceOf(PlaceResults::class)
        ->and($results->results)
        ->toBeInstanceOf(DataCollection::class)
        ->and($results->results[0])
        ->toBeInstanceOf(Place::class)
        ->country->toBe('Deutschland')
        ->name->toBe('Ebertstrasse 23');
});
