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
            ->hasRoute('api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-apple-maps_table')
            ->hasCommand(AppleMapsCommand::class);
    }

    public function registeringPackage()
    {
        parent::registeringPackage();

        $this->app->bind('apple-maps', function () {
            return new AppleMaps;
        });
    }
}
