<?php

namespace Inventas\AppleMaps\Requests;

use Inventas\AppleMaps\Common\TokenResponse;
use Inventas\AppleMaps\TokenGenerator;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetMapsAccessTokenRequest extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/v1/token";
    }

    protected function defaultHeaders(): array
    {
        $token = (new TokenGenerator())->token();

        return [
            "Authorization" => "Bearer $token"
        ];
    }

    public function createDtoFromResponse(Response $response): TokenResponse
    {
        return TokenResponse::from($response->json());
    }
}
