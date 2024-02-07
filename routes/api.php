<?php

use Illuminate\Support\Facades\Route;
use Inventas\AppleMaps\Controller\AnnotationController;
use Inventas\AppleMaps\Controller\AppleMapsController;

Route::group([
    'prefix' => 'api',
    'as' => 'api.',
    'middleware' => config('apple-maps.api_middleware'),
], function () {
    Route::group([
        'prefix' => 'v1',
        'as' => 'v1.',
    ], function () {

        Route::get('apple-maps/token', [AppleMapsController::class, 'token'])
            ->name('apple-maps.token');

        Route::get('apple-maps/geocode', [AppleMapsController::class, 'geocode'])
            ->name('apple-maps.geocode');

        Route::get('apple-maps/annotation/preview', [AnnotationController::class, 'previewAnnotation'])
            ->name('apple-maps.annotation.preview');

    });
});
