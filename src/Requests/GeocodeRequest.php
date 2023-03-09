<?php

namespace Inventas\AppleMaps\Requests;

use Inventas\AppleMaps\Common\PlaceResults;
use Inventas\AppleMaps\Common\SearchLocation;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GeocodeRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @var string (Required) The address to geocode.
     * For example: q=1 Apple Park, Cupertino, CA
     */
    public string $q;

    public array $limitToCountries = [];

    /**
     * @var string The language the server should use when returning the response,
     * specified using a BCP 47 language code. For example, for English use lang=en-US.
     * Default: en-US
     */
    public string $lang = 'en-US';

    public ?SearchLocation $searchLocation;

    public function __construct(
        string $q,
        string $lang = 'en-US',
        ?SearchLocation $searchLocation = null,
    ) {
        $this->q = $q;
        $this->lang = $lang;
        $this->searchLocation = $searchLocation;
    }

    public function resolveEndpoint(): string
    {
        return '/v1/geocode';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'q' => $this->q,
            'lang' => $this->lang,
            'searchLocation' => $this->searchLocation ? (string) $this->searchLocation : null,
        ], fn ($value) => !is_null($value));
    }

    public function createDtoFromResponse(Response $response): PlaceResults
    {
        return PlaceResults::from($response->json());
    }
}
