<?php

namespace Inventas\AppleMaps\Requests;

use Inventas\AppleMaps\Common\Geocoding\TokenResponse;
use Inventas\AppleMaps\TokenGenerator;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMapsAccessTokenRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/token';
    }

    protected function defaultHeaders(): array
    {
        $token = (new TokenGenerator)->token();

        return [
            'Authorization' => "Bearer $token",
        ];
    }

    public function createDtoFromResponse(Response $response): TokenResponse
    {
        return TokenResponse::from($response->json());
    }
}
