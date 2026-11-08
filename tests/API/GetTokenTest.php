<?php

use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

use function Pest\Laravel\getJson;

beforeEach(fn () => enableAppleMapsRoutes());

it('returns the locally signed token with its original claims', function () {
    $response = getJson('/api/v1/apple-maps/token');

    expect($response)
        ->status()->toBe(200)
        ->and($response)
        ->assertJsonStructure(['accessToken', 'expiresInSeconds']);

    $token = (new Parser(new JoseEncoder))->parse($response->json('accessToken'));

    expect($token->claims()->has('scope'))->toBeFalse()
        ->and($token->claims()->has('origin'))->toBeFalse();
});

it('restricts the token to the configured origin', function () {
    config(['apple-maps.token_origin' => 'https://example.com']);

    $response = getJson('/api/v1/apple-maps/token')->assertOk();
    $token = (new Parser(new JoseEncoder))->parse($response->json('accessToken'));

    expect($token->claims()->get('origin'))->toBe('https://example.com');
});
