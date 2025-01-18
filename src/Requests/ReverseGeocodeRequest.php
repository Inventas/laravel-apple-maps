<?php

namespace Inventas\AppleMaps\Requests;

use Inventas\AppleMaps\Common\Geocoding\PlaceResults;
use Inventas\AppleMaps\Common\Geocoding\SearchLocation;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ReverseGeocodeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected SearchLocation $location,
        protected string $language = 'en-US',
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/reverseGeocode';
    }

    protected function defaultQuery(): array
    {
        return [
            'loc' => $this->location->toString(),
            'lang' => $this->language,
        ];
    }

    public function createDtoFromResponse(Response $response): PlaceResults
    {
        return PlaceResults::from($response->json());
    }
}
