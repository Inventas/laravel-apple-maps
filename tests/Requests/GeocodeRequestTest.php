<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\GeocodeQuery;
use Inventas\AppleMaps\Common\PlaceResults;
use Inventas\AppleMaps\Requests\GeocodeRequest;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Spatie\LaravelData\DataCollection;

test('it can geocode an address', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::fixture('geocode.berlin.token'),
        GeocodeRequest::class => MockResponse::fixture('geocode.berlin'),
    ]);

    $connector = new AppleMapsConnector();
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
        ->and($results)->results->toBeInstanceOf(DataCollection::class);
});
