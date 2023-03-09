<?php

namespace Inventas\AppleMaps;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;

class AppleMapsConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://maps-api.apple.com/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return new AppleMapsAuthenticator;
    }
}
