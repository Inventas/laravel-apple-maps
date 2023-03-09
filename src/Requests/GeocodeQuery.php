<?php

namespace Inventas\AppleMaps\Requests;

use Spatie\LaravelData\Data;

class GeocodeQuery extends Data {

    public function __construct(
        public string $q,
    ) {
    }

}
