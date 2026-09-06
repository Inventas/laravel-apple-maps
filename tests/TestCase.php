<?php

namespace Inventas\AppleMaps\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inventas\AppleMaps\AppleMapsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RuntimeException;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Inventas\\AppleMaps\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelDataServiceProvider::class,
            AppleMapsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $privateKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);

        if ($privateKey === false || ! openssl_pkey_export($privateKey, $privateKeyPem)) {
            throw new RuntimeException('Unable to generate the Apple Maps test key.');
        }

        $app['config']->set([
            'apple-maps.key_id' => 'TESTKEYID',
            'apple-maps.private_key' => $privateKeyPem,
            'apple-maps.team_id' => 'TESTTEAMID',
            'database.default' => 'testing',
        ]);
    }
}
