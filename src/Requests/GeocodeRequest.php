<?php

namespace Inventas\AppleMaps\Requests;

use Inventas\AppleMaps\Common\Geocoding\GeocodeQuery;
use Inventas\AppleMaps\Common\Geocoding\PlaceResults;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GeocodeRequest extends Request
{
    protected Method $method = Method::GET;

    protected GeocodeQuery $geocodeQuery;

    public function __construct(
        GeocodeQuery $query
    ) {
        $this->geocodeQuery = $query;
    }

    public function resolveEndpoint(): string
    {
        return '/v1/geocode';
    }

    protected function defaultQuery(): array
    {
        return $this->geocodeQuery->toQuery();
    }

    public function createDtoFromResponse(Response $response): PlaceResults
    {
        return PlaceResults::from($response->json());
    }
}
