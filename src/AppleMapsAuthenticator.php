<?php

namespace Inventas\AppleMaps;

use Illuminate\Support\Facades\Cache;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class AppleMapsAuthenticator implements Authenticator
{
    const KEY = 'apple-maps-access-token';

    public function set(PendingRequest $pendingRequest): void
    {
        // Make sure to ignore the authentication request to prevent loops.
        if ($pendingRequest->getRequest() instanceof GetMapsAccessTokenRequest) {
            return;
        }

        // Check if we have a cached access token.
        $token = Cache::get(self::KEY);

        if ($token) {
            $pendingRequest->headers()->add('Authorization', 'Bearer '.$token);

            return;
        }

        // Make a request to the Authentication endpoint using the same connector.
        $response = $pendingRequest->getConnector()->send(new GetMapsAccessTokenRequest);
        $expiresInSeconds = $response->json('expiresInSeconds');
        $accessToken = $response->json('accessToken');

        Cache::put(self::KEY, $accessToken, $expiresInSeconds);

        // Finally, authenticate the previous PendingRequest before it is sent.
        $pendingRequest->headers()->add('Authorization', 'Bearer '.$accessToken);
    }
}
