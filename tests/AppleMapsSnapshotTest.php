<?php

use Inventas\AppleMaps\AppleMapsSnapshot;
use Inventas\AppleMaps\Common\Geocoding\Location;
use Inventas\AppleMaps\Common\Snapshot\SnapshotAnnotation;
use Inventas\AppleMaps\Common\Snapshot\SnapshotMarkerStyle;
use Inventas\AppleMaps\Common\Snapshot\SnapshotQuery;

it('generates a map snapshot', function () {

    $location = new Location(
        latitude: 37.33182,
        longitude: -122.03118,
    );

    $signedURL = AppleMapsSnapshot::snapshotUrl(
        center: $location,
        query: new SnapshotQuery,
        annotations: [
            new SnapshotAnnotation(
                point: $location,
                color: '2563EB',
                markerStyle: SnapshotMarkerStyle::Balloon,
            ),
        ]
    );

    expect($signedURL)->toBeString();

});

it('generates a map snapshot (auto center)', function () {

    $location = new Location(
        latitude: 37.33182,
        longitude: -122.03118,
    );

    $signedURL = AppleMapsSnapshot::autoSnapshotUrl(
        query: new SnapshotQuery,
        annotations: [
            new SnapshotAnnotation(
                point: $location,
                color: '2563EB',
                markerStyle: SnapshotMarkerStyle::Balloon,
            ),
        ]
    );

    expect($signedURL)->toBeString();

});
