<?php

namespace Inventas\AppleMaps;

use Inventas\AppleMaps\Commands\AppleMapsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AppleMapsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-apple-maps')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(AppleMapsCommand::class);
    }

    /**
     * The routes call Apple with the application's key, so they are only registered when enabled.
     */
    public function packageBooted(): void
    {
        if (filter_var(config('apple-maps.routes'), FILTER_VALIDATE_BOOL)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        }
    }

    public function registeringPackage()
    {
        parent::registeringPackage();

        $this->app->bind('apple-maps', function () {
            return new AppleMaps;
        });
    }
}
