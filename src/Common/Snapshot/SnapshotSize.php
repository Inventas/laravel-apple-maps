<?php

namespace Inventas\AppleMaps\Common\Snapshot;

use Spatie\LaravelData\Attributes\Validation\GreaterThanOrEqualTo;
use Spatie\LaravelData\Attributes\Validation\LessThanOrEqualTo;
use Spatie\LaravelData\Data;

class SnapshotSize extends Data
{

    public function __construct(
        #[GreaterThanOrEqualTo(50)]
        #[LessThanOrEqualTo(640)]
        public int $width = 600,
        #[GreaterThanOrEqualTo(50)]
        #[LessThanOrEqualTo(640)]
        public int $height = 400,
    ) {

    }

    public function __toString(): string {
        return "{$this->width}x{$this->height}";
    }

    public function toString(): string {
        return $this->__toString();
    }
}
