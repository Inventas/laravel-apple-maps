<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\Geocoding\GeocodeQuery;
use Inventas\AppleMaps\Common\Geocoding\Place;
use Inventas\AppleMaps\Common\Geocoding\PlaceResults;
use Inventas\AppleMaps\Requests\GeocodeRequest;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Tests\Support\AppleMapsResponseFactory;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Spatie\LaravelData\DataCollection;

test('it can geocode an address', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::make(AppleMapsResponseFactory::token()),
        GeocodeRequest::class => MockResponse::make(AppleMapsResponseFactory::placeResults(
            name: 'Pariser Platz 8',
            latitude: 52.5165866,
            longitude: 13.3778827,
        )),
    ]);

    $connector = new AppleMapsConnector;
    $connector->withMockClient($mockClient);
    $request = new GeocodeRequest(
        new GeocodeQuery(
            q: 'Pariser Platz 8, 10117 Berlin Deutschland',
            lang: 'de-DE',
        )
    );

    $response = $connector->send($request);

    /** @var PlaceResults $results */
    $results = $response->dto();

    expect($response->status())->toBe(200)
        ->and($results->results)->toBeInstanceOf(DataCollection::class)
        ->and($results->results[0])->toBeInstanceOf(Place::class)
        ->country->toBe('Deutschland')
        ->name->toBe('Pariser Platz 8');
});
