<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\TokenResponse;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('get token', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::fixture('token'),
    ]);

    $connector = new AppleMapsConnector();
    $connector->withMockClient($mockClient);
    $request = new GetMapsAccessTokenRequest();
    $response = $connector->send($request);

    $accessTokenResponse = $response->dto();

    expect($accessTokenResponse)->toBeInstanceOf(TokenResponse::class)
        ->and($accessTokenResponse)->accessToken->toBeString()->not()->toBeEmpty()
        ->and($accessTokenResponse)->expiresInSeconds->toBeInt()->toBe(1800);
});
