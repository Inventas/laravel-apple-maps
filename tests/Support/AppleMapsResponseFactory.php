<?php

namespace Inventas\AppleMaps\Tests\Support;

final class AppleMapsResponseFactory
{
    public static function token(): array
    {
        return [
            'accessToken' => 'test-access-token',
            'expiresInSeconds' => 1800,
        ];
    }

    public static function placeResults(string $name, float $latitude, float $longitude): array
    {
        return [
            'results' => [
                [
                    'coordinate' => [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                    ],
                    'displayMapRegion' => [
                        'southLatitude' => $latitude - 0.01,
                        'westLongitude' => $longitude - 0.01,
                        'northLatitude' => $latitude + 0.01,
                        'eastLongitude' => $longitude + 0.01,
                    ],
                    'name' => $name,
                    'formattedAddressLines' => [
                        $name,
                        '10117 Berlin',
                        'Deutschland',
                    ],
                    'structuredAddress' => [
                        'administrativeArea' => 'Berlin',
                        'administrativeAreaCode' => 'BE',
                        'areasOfInterest' => null,
                        'dependentLocalities' => null,
                        'fullThoroughfare' => $name,
                        'locality' => 'Berlin',
                        'postCode' => '10117',
                        'subLocality' => 'Mitte',
                        'subThoroughfare' => null,
                        'thoroughfare' => null,
                    ],
                    'country' => 'Deutschland',
                    'countryCode' => 'DE',
                ],
            ],
        ];
    }
}
