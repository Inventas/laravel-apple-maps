<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Requests\GeocodeRequest;

test('it can geocode an address', function () {

    $connector = new AppleMapsConnector();
    $request = new GeocodeRequest(
        q: 'Pariser Platz 8, 10117 Berlin Deutschland',
        lang: 'de-DE',
    );

    $response = $connector->send($request);

    expect($response->status())->toBe(200);
});
