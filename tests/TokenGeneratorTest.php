<?php

use Inventas\AppleMaps\Facades\AppleMaps;
use Inventas\AppleMaps\TokenGenerator;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

it('adds the origin claim when an origin is given', function () {
    $token = (new TokenGenerator)->issue(
        keyIdentifier: 'TESTKEYID',
        issuer: 'TESTTEAMID',
        privateKey: config('apple-maps.private_key'),
        origin: 'https://example.com',
    );

    expect($token->claims()->get('origin'))->toBe('https://example.com')
        ->and($token->claims()->get('iss'))->toBe('TESTTEAMID')
        ->and($token->headers()->get('kid'))->toBe('TESTKEYID');
});

it('issues tokens without an origin claim by default', function () {
    $token = (new TokenGenerator)->issue(
        keyIdentifier: 'TESTKEYID',
        issuer: 'TESTTEAMID',
        privateKey: config('apple-maps.private_key'),
    );

    expect($token->claims()->has('origin'))->toBeFalse();
});

it('prefers an explicit origin over the configured one for intermediate tokens', function () {
    config(['apple-maps.token_origin' => 'https://configured.example']);

    $parse = fn (string $token) => (new Parser(new JoseEncoder))->parse($token)->claims()->get('origin');

    expect($parse(AppleMaps::getIntermediateToken()))->toBe('https://configured.example')
        ->and($parse(AppleMaps::getIntermediateToken(origin: 'https://explicit.example')))->toBe('https://explicit.example');
});
