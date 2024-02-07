<?php

namespace Inventas\AppleMaps\Common\Snapshot;

enum SnapshotMapType: string
{
    case Standard = 'standard';
    case Hybrid = 'hybrid';
    case Satellite = 'satellite';
    case MutedStandard = 'mutedStandard';
}
