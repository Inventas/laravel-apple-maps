<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Team ID
    |--------------------------------------------------------------------------
    |
    | This value is the team id of your Apple Developer Account.
    | You can find this value by logging in to your Apple Developer Account
    | at the top right corner.
    |
    */
    'team_id' => env('APPLE_MAPS_TEAM_ID'),

    /*
    |--------------------------------------------------------------------------
    | Key ID
    |--------------------------------------------------------------------------
    |
    | When creating an Apple Maps key, you get a key id.
    | This is typically ten characters long.
    |
    */
    'key_id' => env('APPLE_MAPS_KEY_ID'),

    /*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    |
    | When creating an Apple Maps key, you download a private key
    | with the file extension `.p8`.
    | Copy the contents of the file to your env file.
    |
    */
    'private_key' => env('APPLE_MAPS_PRIVATE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Token Origin
    |--------------------------------------------------------------------------
    |
    | The origin added to MapKit JS tokens, for example https://example.com.
    | Apple accepts such a token only from pages served by that origin, so a
    | copied token cannot be used on another site. Leave empty to issue
    | tokens without an origin restriction.
    |
    */
    'token_origin' => env('APPLE_MAPS_TOKEN_ORIGIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Routes
    |--------------------------------------------------------------------------
    |
    | The package's token, geocoding and annotation preview routes use your
    | Apple Maps key and quota. Protect them with authentication middleware
    | or set this to false if your application does not call them. The
    | default will change to false in the next major version.
    |
    */
    'routes' => (bool) env('APPLE_MAPS_ROUTES', true),

    'api_middleware' => 'api',
];
