<?php

use Inventas\AppleMaps\AppleMaps as AppleMapsClient;
use Inventas\AppleMaps\Facades\AppleMaps;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Tests\Support\AppleMapsResponseFactory;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('generates a token', function () {
    $appleMaps = new AppleMapsClient;
    $appleMaps->connector->withMockClient(new MockClient([
        GetMapsAccessTokenRequest::class => MockResponse::make(AppleMapsResponseFactory::token()),
    ]));
    AppleMaps::swap($appleMaps);

    $token = AppleMaps::getToken();
    $accessToken = $token->accessToken;

    expect($token->expiresInSeconds)->toBe(1800)
        ->and($accessToken)
        ->toBe('test-access-token');
});
