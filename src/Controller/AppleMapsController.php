<?php

namespace Inventas\AppleMaps\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Inventas\AppleMaps\Common\TokenResponse;
use Inventas\AppleMaps\Facades\AppleMaps;

class AppleMapsController extends Controller
{

    public function token(): JsonResponse {

        /** @var TokenResponse $tokenResponse */
        $tokenResponse = AppleMaps::getToken();

        return new JsonResponse($tokenResponse->toArray(), 200);
    }

}
