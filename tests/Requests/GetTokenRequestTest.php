<?php

use Inventas\AppleMaps\AppleMapsConnector;
use Inventas\AppleMaps\Common\Geocoding\TokenResponse;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Tests\Support\AppleMapsResponseFactory;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('exchanges a signed server API token for an access token', function () {
    $mockClient = new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::make(AppleMapsResponseFactory::token()),
    ]);

    $connector = new AppleMapsConnector;
    $connector->withMockClient($mockClient);
    $request = new GetMapsAccessTokenRequest;
    $response = $connector->send($request);

    $authorization = $response->getPendingRequest()->headers()->get('Authorization');
    expect($authorization)->toStartWith('Bearer ');

    $token = (new Parser(new JoseEncoder))->parse(substr($authorization, strlen('Bearer ')));
    expect($token->claims()->get('scope'))->toBe('server_api');

    $accessTokenResponse = $response->dto();

    expect($accessTokenResponse)->toBeInstanceOf(TokenResponse::class)
        ->and($accessTokenResponse)->accessToken->toBe('test-access-token')
        ->and($accessTokenResponse)->expiresInSeconds->toBeInt()->toBe(1800);
});
