<?php

namespace Inventas\AppleMaps\Common\Geocoding;

use Spatie\LaravelData\Data;

class GeocodeQuery extends Data
{
    /**
     * @var string The language the server should use when returning the response,
     * specified using a BCP 47 language code. For example, for English use lang=en-US.
     * Default: en-US
     */
    public string $lang = 'en-US';

    public function __construct(
        public string $q,
        public array $limitToCountries = [],
        string $lang = 'en-US',
        public ?SearchLocation $searchLocation = null,
        public ?SearchRegion $searchRegion = null,
        public ?SearchLocation $userLocation = null,
    ) {
        $this->lang = $lang;
    }

    public function toQuery(): array
    {
        return array_filter([
            'q' => $this->q,
            'lang' => $this->lang,
            'searchLocation' => $this->searchLocation ? (string) $this->searchLocation : null,
            'limitToCountries' => ! empty($this->limitToCountries) ? implode(',', $this->limitToCountries) : null,
            'searchRegion' => $this->searchRegion ? (string) $this->searchRegion : null,
            'userLocation' => $this->userLocation ? (string) $this->userLocation : null,
        ], fn ($value) => ! is_null($value));
    }
}
