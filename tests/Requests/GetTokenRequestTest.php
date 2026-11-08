<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\Geocoding\TokenResponse;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Tests\Support\AppleMapsResponseFactory;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('get token', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::make(AppleMapsResponseFactory::token()),
    ]);

    $connector = new AppleMapsConnector;
    $connector->withMockClient($mockClient);
    $request = new GetMapsAccessTokenRequest;
    $response = $connector->send($request);

    $accessTokenResponse = $response->dto();

    expect($accessTokenResponse)->toBeInstanceOf(TokenResponse::class)
        ->and($accessTokenResponse)->accessToken->toBe('test-access-token')
        ->and($accessTokenResponse)->expiresInSeconds->toBeInt()->toBe(1800);
});
