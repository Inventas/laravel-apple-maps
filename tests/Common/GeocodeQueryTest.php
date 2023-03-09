<?php

use Inventas\AppleMaps\Common\GeocodeQuery;
use Inventas\AppleMaps\Common\SearchLocation;
use Inventas\AppleMaps\Common\SearchRegion;

it('encodes query (q with lang)', function () {

    $query = new GeocodeQuery(
        q: 'Pariser Platz 8, 10117 Berlin Deutschland',
    );

    expect($query->toQuery())
        ->toBeArray()
        ->toBe([
            'q' => 'Pariser Platz 8, 10117 Berlin Deutschland',
            'lang' => 'en-US',
        ]);

});

it('encodes query (q, limitToCountries)', function () {

    $query = new GeocodeQuery(
        q: 'Pariser Platz 8, 10117 Berlin Deutschland',
        limitToCountries: ['DE', 'US', 'CA'],
    );

    expect($query->toQuery())
        ->toBeArray()
        ->toBe([
            'q' => 'Pariser Platz 8, 10117 Berlin Deutschland',
            'lang' => 'en-US',
            'limitToCountries' => 'DE,US,CA'
        ]);

});

it('encodes query (q, searchLocation)', function () {

    $query = new GeocodeQuery(
        q: 'Pariser Platz 8, 10117 Berlin Deutschland',
        searchLocation: new SearchLocation(52.520008, 13.404954),
    );

    expect($query->toQuery())
        ->toBeArray()
        ->toBe([
            'q' => 'Pariser Platz 8, 10117 Berlin Deutschland',
            'lang' => 'en-US',
            'searchLocation' => '52.520008,13.404954'
        ]);

});

it('encodes query (q, userLocation)', function () {

    $query = new GeocodeQuery(
        q: 'Pariser Platz 8, 10117 Berlin Deutschland',
        userLocation: new SearchLocation(52.10402, 12.404954),
    );

    expect($query->toQuery())
        ->toBeArray()
        ->toBe([
            'q' => 'Pariser Platz 8, 10117 Berlin Deutschland',
            'lang' => 'en-US',
            'userLocation' => '52.10402,12.404954'
        ]);

});

it('encodes query (q, searchRegion)', function () {

    $query = new GeocodeQuery(
        q: 'Pariser Platz 8, 10117 Berlin Deutschland',
        searchRegion: new SearchRegion(
            northLatitude: 52.520008,
            eastLongitude: 12.404954,
            southLatitude: 52.10402,
            westLongitude: 13.404954,
        )
    );

    expect($query->toQuery())
        ->toBeArray()
        ->toBe([
            'q' => 'Pariser Platz 8, 10117 Berlin Deutschland',
            'lang' => 'en-US',
            'searchRegion' => '52.520008,12.404954,52.10402,13.404954'
        ]);

});
