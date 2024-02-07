<?php

namespace Inventas\AppleMaps\Common\Snapshot;

use Spatie\LaravelData\Attributes\Validation\GreaterThanOrEqualTo;
use Spatie\LaravelData\Attributes\Validation\LessThanOrEqualTo;
use Spatie\LaravelData\Data;

class SnapshotQuery extends Data
{
    #[GreaterThanOrEqualTo(3)]
    #[LessThanOrEqualTo(20)]
    public int $zoom = 12;

    public SnapshotSize $size;

    public SnapshotScale $scale;

    public SnapshotMapType $mapType = SnapshotMapType::Standard;

    public SnapshotColorScheme $colorScheme = SnapshotColorScheme::Light;

    public bool $showPointsOfInterest = true;

    public string $lang = 'en-US';

    public function __construct(
        int $zoom = 12,
        ?SnapshotSize $size = null,
        SnapshotScale $scale = SnapshotScale::Two,
        SnapshotColorScheme $colorScheme = SnapshotColorScheme::Light,
        SnapshotMapType $mapType = SnapshotMapType::Standard,
        bool $showPointsOfInterest = true,
        string $lang = 'en-US'
    ) {
        $this->zoom = $zoom;
        $this->size = $size ?? new SnapshotSize();
        $this->scale = $scale;
        $this->colorScheme = $colorScheme;
        $this->mapType = $mapType;
        $this->showPointsOfInterest = $showPointsOfInterest;
        $this->lang = $lang;
    }

    public function toQuery(): array
    {
        return array_filter([
            'z' => $this->zoom,
            'size' => $this->size->toString(),
            'lang' => $this->lang,
            'scale' => $this->scale->value,
            't' => $this->mapType->value,
            'colorScheme' => $this->colorScheme->value,
            'poi' => $this->showPointsOfInterest ? 1 : 0,
        ], fn ($value) => ! is_null($value));
    }
}
