<?php

namespace Inventas\AppleMaps\Common;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PlaceResults extends Data
{

    public function __construct(
        #[DataCollectionOf(Place::class)]
        public DataCollection $results,
    ) {

    }

}
