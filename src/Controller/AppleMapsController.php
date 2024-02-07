<?php

namespace Inventas\AppleMaps\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Inventas\AppleMaps\Common\Geocoding\GeocodeQuery;
use Inventas\AppleMaps\Common\Geocoding\TokenResponse;
use Inventas\AppleMaps\Facades\AppleMaps;

class AppleMapsController extends Controller
{
    public function token(): JsonResponse
    {
        $tokenResponse = new TokenResponse(
            accessToken: AppleMaps::getIntermediateToken(),
            expiresInSeconds: 30 * 60,
        );

        return new JsonResponse($tokenResponse->toArray(), 200);
    }

    public function geocode(): JsonResponse
    {
        $q = request()->query('q');
        $query = new GeocodeQuery(q: $q);
        $response = AppleMaps::geocode($query);

        return new JsonResponse($response, 200);
    }
}
