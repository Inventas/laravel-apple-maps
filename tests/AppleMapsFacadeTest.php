<?php

use Inventas\AppleMaps\Facades\AppleMaps;

it('generates a token', function () {
    $token = AppleMaps::getToken();
    $accessToken = $token->accessToken;

    expect($token->expiresInSeconds)->toBe(1800)
        ->and($accessToken)
        ->toBeString()
        ->and($accessToken)
        ->not()->toBeEmpty();
});
