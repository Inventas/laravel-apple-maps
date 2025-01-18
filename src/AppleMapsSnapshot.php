<?php

namespace Inventas\AppleMaps;

use Inventas\AppleMaps\Common\Geocoding\Location;
use Inventas\AppleMaps\Common\Snapshot\SnapshotAnnotation;
use Inventas\AppleMaps\Common\Snapshot\SnapshotQuery;

class AppleMapsSnapshot
{
    public static string $snapshotBaseUrl = 'https://snapshot.apple-mapkit.com';

    public static string $snapshotPath = '/api/v1/snapshot';

    public static array $jsonParams = [
        'annotations',
        'overlays',
        'imgs',
    ];

    /**
     * Generates a signed URL to an Apple Maps snapshot image.
     *
     * @param  Location  $center  The center of the map, specified as either coordinates or an address
     * @return false|string
     */
    public static function snapshotUrl(
        Location $center,
        SnapshotQuery $query,
        array $annotations = [],
    ): bool|string {
        return self::baseSnapshotUrl($center->toString(), $query, $annotations);
    }

    public static function autoSnapshotUrl(SnapshotQuery $query, array $annotations = []): bool|string
    {
        return self::baseSnapshotUrl('auto', $query, $annotations);
    }

    private static function baseSnapshotUrl(
        string $center,
        SnapshotQuery $query,
        array $annotations = []
    ): bool|string {
        $teamId = config('apple-maps.team_id');
        $keyId = config('apple-maps.key_id');
        $privateKey = config('apple-maps.private_key');
        $privateKey = PrivateKeySanitizer::sanitize(privateKey: $privateKey);

        //        foreach (static::$jsonParams as $param) {
        //            if (isset($additionalParams[$param])) {
        //                $additionalParams[$param] = json_encode($additionalParams[$param]);
        //            }
        //        }

        $parsedAnnotations = collect($annotations)
            ->map(function (SnapshotAnnotation $annotation) {
                return $annotation->toArray();
            })
            ->toArray();

        $params = array_merge([
            'center' => $center,
            'teamId' => $teamId,
            'keyId' => $keyId,
            'annotations' => json_encode($parsedAnnotations),
        ], $query->toQuery());

        $request_uri = static::$snapshotPath.'?'.http_build_query($params);

        if (! $key = openssl_pkey_get_private($privateKey)) {
            return false;
        }

        if (! openssl_sign($request_uri, $signature, $key, OPENSSL_ALGO_SHA256)) {
            return false;
        }

        return static::$snapshotBaseUrl.$request_uri.'&signature='.urlencode(base64_encode($signature));
    }
}
