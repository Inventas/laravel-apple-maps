<?php

namespace Inventas\AppleMaps;

use Illuminate\Support\Facades\Cache;
use Inventas\AppleMaps\Common\Geocoding\GeocodeQuery;
use Inventas\AppleMaps\Common\Geocoding\PlaceResults;
use Inventas\AppleMaps\Common\Geocoding\SearchLocation;
use Inventas\AppleMaps\Common\Geocoding\TokenResponse;
use Inventas\AppleMaps\Requests\GeocodeRequest;
use Inventas\AppleMaps\Requests\GetMapsAccessTokenRequest;
use Inventas\AppleMaps\Requests\ReverseGeocodeRequest;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class AppleMaps
{
    public AppleMapsConnector $connector;

    public function __construct()
    {
        $this->connector = new AppleMapsConnector();
    }

    /**
     * Get an Apple Maps auth token with a validity of 30 minutes.
     *
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getToken(): TokenResponse
    {
        return Cache::remember('apple-maps-token', 30, function () {
            return $this->getNewToken();
        });
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function getNewToken(): TokenResponse
    {
        $request = new GetMapsAccessTokenRequest();
        $response = $this->connector->send($request);

        return $response->dtoOrFail();
    }

    public function getIntermediateToken(): string
    {
        return (new TokenGenerator())->token(lifetime: 30 * 60);
    }

    public function geocode(GeocodeQuery $query): PlaceResults
    {
        $request = new GeocodeRequest(
            query: $query,
        );

        $response = $this->connector->send($request);

        /** @var PlaceResults $results */
        $results = $response->dto();

        return $results;
    }

    public function reverseGeocode(SearchLocation $searchLocation): PlaceResults
    {
        $request = new ReverseGeocodeRequest(
            location: $searchLocation
        );

        $response = $this->connector->send($request);

        /** @var PlaceResults $results */
        $results = $response->dto();

        return $results;
    }
}
