<?php

use Inventas\AppleMaps\Common\Geocoding\Location;
use Inventas\AppleMaps\Common\Snapshot\SnapshotAnnotation;
use Inventas\AppleMaps\Common\Snapshot\SnapshotMarkerStyle;

it('can be turned into array', function () {

    $annotation = new SnapshotAnnotation(
        new Location(1, 2),
        'red',
        'A',
        SnapshotMarkerStyle::Dot,
    );

    expect($annotation->toArray())->toEqual([
        'point' => '1,2',
        'color' => 'red',
        'glyphText' => 'A',
        'markerStyle' => 'dot',
    ]);

});
