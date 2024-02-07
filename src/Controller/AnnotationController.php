<?php

namespace Inventas\AppleMaps\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Inventas\AppleMaps\AppleMapsSnapshot;
use Inventas\AppleMaps\Common\Geocoding\Location;
use Inventas\AppleMaps\Common\Snapshot\SnapshotAnnotation;
use Inventas\AppleMaps\Common\Snapshot\SnapshotQuery;
use Inventas\AppleMaps\Common\Snapshot\SnapshotSize;

class AnnotationController extends Controller
{
    public function previewAnnotation(): JsonResponse
    {
        $data = Validator::make(request()->query(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'latitude.numeric' => 'The latitude must be numeric.',
            'longitude.numeric' => 'The longitude must be numeric.',
            'latitude.between' => 'The latitude must be in range between -90 and 90.',
            'longitude.between' => 'The longitude mus be in range between -180 and 180.',
        ])->validate();

        $url = AppleMapsSnapshot::autoSnapshotUrl(new SnapshotQuery(
            zoom: 16,
            size: new SnapshotSize(width: 300, height: 300),
        ), [
            new SnapshotAnnotation(
                point: new Location(
                    latitude: $data['latitude'],
                    longitude: $data['longitude']
                ),
                color: 'red',
            ),
        ]);

        return new JsonResponse(['url' => $url], 200);
    }
}
