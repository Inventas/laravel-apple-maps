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


    'api_middleware' => 'api'
];
