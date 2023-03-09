<?php

use function Pest\Laravel\getJson;

it('get token', function () {

    $response = getJson('/api/v1/apple-maps/token');

    expect($response)
        ->status()->toBe(200)
        ->and($response)
        ->assertJsonStructure(['accessToken', 'expiresInSeconds']);

});
