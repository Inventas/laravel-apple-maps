<?php

use Inventas\AppleMaps\Common\Snapshot\SnapshotQuery;

it('encodes query (z)', function () {
    $query = new SnapshotQuery(
        zoom: 15,
    );

    expect($query->toQuery())
        ->toBeArray()
        ->toBe([
            'z' => 15,
            'size' => '600x400',
            'lang' => 'en-US',
            'scale' => 2,
            't' => 'standard',
            'colorScheme' => 'light',
            'poi' => 1,
        ]);
});
