<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\TokenResponse;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;

test('get token', function () {
    $connector = new AppleMapsConnector();
    $request = new GetMapsAccessTokenRequest();
    $response = $connector->send($request);

    $accessToken = $response->json('accessToken');
    $expiresInSeconds = $response->json('expiresInSeconds');

    expect($accessToken)->toBeString()->not()->toBeEmpty()
        ->and($expiresInSeconds)->toBeInt()->toBe(1800)
        ->and($response->dto())->toBeInstanceOf(TokenResponse::class);

});
