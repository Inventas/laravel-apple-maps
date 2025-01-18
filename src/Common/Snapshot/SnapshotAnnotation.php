<?php

namespace Inventas\AppleMaps\Common\Snapshot;

use Inventas\AppleMaps\Common\Geocoding\Location;
use Spatie\LaravelData\Data;

class SnapshotAnnotation extends Data
{
    public function __construct(
        public Location $point,
        public string $color,
        public ?string $glyphText = null,
        public SnapshotMarkerStyle $markerStyle = SnapshotMarkerStyle::Balloon,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'point' => $this->point->toString(),
            'color' => $this->color,
            'glyphText' => $this->glyphText,
            'markerStyle' => $this->markerStyle->value,
        ], fn ($value) => ! is_null($value));
    }
}
