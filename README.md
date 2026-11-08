# A Laravel SDK for the Apple Maps Server API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inventas/laravel-apple-maps.svg?style=flat-square)](https://packagist.org/packages/inventas/laravel-apple-maps)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/inventas/laravel-apple-maps/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inventas/laravel-apple-maps/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/inventas/laravel-apple-maps/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/inventas/laravel-apple-maps/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/inventas/laravel-apple-maps.svg?style=flat-square)](https://packagist.org/packages/inventas/laravel-apple-maps)

Use this package to convert addresses to coordinates, look up addresses from coordinates, and generate signed URLs for static Apple Maps images. The package uses your Apple Maps private key to sign tokens and snapshot URLs on your Laravel server.

## Setup

### 1. Install the package

Version 2 supports these Laravel and PHP versions. [Laravel PHP requirements](https://laravel.com/docs/13.x/releases#support-policy)

| Laravel version | Minimum PHP version |
| --- | --- |
| 12.61.1 and later in the 12.x series | 8.2 |
| 13.12 and later in the 13.x series | 8.3 |

Enable the PHP `openssl` and `sodium` extensions. Run this command from the root of your Laravel application.

```bash
composer require 'inventas/laravel-apple-maps:^2.0'
```

Laravel discovers the service provider automatically. The package needs a working Laravel cache store for Apple Maps access tokens. No package migrations or views are required.

When you upgrade from version 1, follow the [upgrade guide](UPGRADE.md).

### 2. Create your Apple Maps credentials

1. Sign in to your [Apple Developer account](https://developer.apple.com/account/) and select the team that will use Apple Maps.
2. Under **Certificates, Identifiers & Profiles**, open **Identifiers**. Click **+**, select **Maps IDs**, and click **Continue**. Enter a description and a reverse-domain identifier such as `maps.com.example.myapp`. Review and register the identifier.
3. Open **Keys**, click **+**, and enter a name for the key. Select **MapKit JS**, click **Configure**, and select the Maps ID from step 2. Save the configuration and register the key.
4. Copy the **Key ID** from the key details and download the `.p8` file. Apple permits one download. Store the file in a secure location.
5. Open **Membership** in your Apple Developer account and copy the **Team ID**. Use the Team ID and Key ID from the same team.

The Maps ID links the key to the service in your Apple Developer account. Laravel uses the Team ID, Key ID, and private key. [Apple's guide to Maps IDs and private keys](https://developer.apple.com/documentation/applemapsserverapi/creating-a-maps-identifier-and-a-private-key)

### 3. Configure Laravel

Add these variables to your Laravel application's `.env` file or supply them through your deployment's secret store. Replace the example values with your own.

```dotenv
APPLE_MAPS_TEAM_ID=YOUR_TEAM_ID
APPLE_MAPS_KEY_ID=YOUR_KEY_ID
APPLE_MAPS_PRIVATE_KEY='-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_BODY\n-----END PRIVATE KEY-----'
```

Set `APPLE_MAPS_PRIVATE_KEY` to the contents of the `.p8` file, including both `PRIVATE KEY` lines. For a single-line value as shown above, replace each line break with a literal `\n`. The package also accepts the original multiline text. Keep the private key on the server and out of source control.

The default config reads these variables. To change package settings such as the middleware for its optional HTTP routes, publish `config/apple-maps.php`.

```bash
php artisan vendor:publish --tag=apple-maps-config
```

If Laravel has cached the configuration, clear it after you change the credentials. On deployments that use a config cache, run `php artisan config:cache` again after the secrets are available.

```bash
php artisan config:clear
```

### 4. Make a test request

If your application has Laravel Tinker, run `php artisan tinker` and enter this example. You can also use the code in a Laravel command or controller. The server needs HTTPS access to `maps-api.apple.com`.

```php
use Inventas\AppleMaps\Common\Geocoding\GeocodeQuery;
use Inventas\AppleMaps\Facades\AppleMaps;

$response = AppleMaps::geocode(new GeocodeQuery(
    q: 'Pariser Platz 8, 10117 Berlin, Germany',
    limitToCountries: ['DE'],
    lang: 'de-DE',
));

foreach ($response->results as $place) {
    dump($place->name, $place->coordinate->latitude, $place->coordinate->longitude);
}
```

You should see a place name and coordinates in Berlin. `limitToCountries` limits the results to Germany. `lang` sets the response language.

The package signs a JWT with the `server_api` scope, exchanges it with Apple for a Maps access token, and caches the access token through Laravel. [Apple's Maps Server API token guide](https://developer.apple.com/documentation/applemapsserverapi/creating-and-using-tokens-with-maps-server-api)

## Usage

### Reverse geocode coordinates

Pass the latitude and longitude to `reverseGeocode()` to find matching addresses. Both geocoding methods return a `PlaceResults` object. Its `results` collection can be empty.

```php
use Inventas\AppleMaps\Common\Geocoding\SearchLocation;
use Inventas\AppleMaps\Facades\AppleMaps;

$response = AppleMaps::reverseGeocode(new SearchLocation(
    latitude: 52.51626,
    longitude: 13.37721,
));

foreach ($response->results as $place) {
    dump($place->formattedAddressLines);
}
```

### Generate a map snapshot

Set the map center, zoom, and image size. You can also add a marker at a coordinate.

```php
use Inventas\AppleMaps\AppleMapsSnapshot;
use Inventas\AppleMaps\Common\Geocoding\Location;
use Inventas\AppleMaps\Common\Snapshot\SnapshotAnnotation;
use Inventas\AppleMaps\Common\Snapshot\SnapshotQuery;
use Inventas\AppleMaps\Common\Snapshot\SnapshotSize;

$center = new Location(latitude: 52.51626, longitude: 13.37721);

$url = AppleMapsSnapshot::snapshotUrl(
    center: $center,
    query: new SnapshotQuery(
        zoom: 16,
        size: new SnapshotSize(width: 600, height: 400),
    ),
    annotations: [new SnapshotAnnotation(point: $center, color: '2563EB')],
);
```

The method signs the URL locally and returns `false` if OpenSSL cannot load the key or sign the URL. Use the returned URL as the `src` of an image. Keep the query parameters and their order to preserve the signature. [Apple's guide to signed snapshot URLs](https://developer.apple.com/documentation/snapshots/generating-a-url-and-signature-to-create-a-maps-web-snapshot)

### Use the built-in HTTP routes

The package's HTTP routes are off by default because they use your Apple Maps key and quota. To register them, set `APPLE_MAPS_ROUTES=true`.

| Method and path | Result |
| --- | --- |
| `GET /api/v1/apple-maps/geocode?q=Berlin` | Places that match the query. |
| `GET /api/v1/apple-maps/annotation/preview?latitude=52.51626&longitude=13.37721` | A signed snapshot URL with a marker at the given coordinates. |
| `GET /api/v1/apple-maps/token` | A locally signed JWT for MapKit JS, valid for 30 minutes, in the `accessToken` JSON field. |

The routes use the `api` middleware group by default. Before you enable the routes, set `api_middleware` in `config/apple-maps.php` to include your application's authentication middleware. For example, if your app already uses Sanctum, set `'api_middleware' => ['api', 'auth:sanctum']`. This setting applies to all three routes.

### Restrict MapKit JS tokens to your site

A MapKit JS token without an `origin` claim works on any website. Set `APPLE_MAPS_TOKEN_ORIGIN` to the scheme and host your pages are served from, such as `https://example.com`, and Apple only accepts the token from that origin. The setting applies to the token route and to `AppleMaps::getIntermediateToken()`. You can also pass an origin directly.

```php
use Inventas\AppleMaps\Facades\AppleMaps;

$token = AppleMaps::getIntermediateToken(origin: 'https://example.com');
```

If your deployment caches configuration and routes, rebuild the configuration cache before you rebuild the route cache. Check the active middleware and paths with this command.

```bash
php artisan route:list --path=api/v1/apple-maps -v
```

## Troubleshooting

| Symptom | What to check |
| --- | --- |
| A signing error occurs before the request reaches Apple. | Check that the server receives all three variables and that the key includes both PEM delimiters. Clear stale configuration with `php artisan config:clear`. |
| Apple rejects the token. | Check that the key is active, has MapKit JS enabled, and belongs to the team and Maps ID you configured. In Tinker, run `\Inventas\AppleMaps\Facades\AppleMaps::getNewToken()->expiresInSeconds` to test a fresh token exchange without printing the token. [Apple's token documentation](https://developer.apple.com/documentation/applemapsserverapi/-v1-token) |
| A geocoding request reports a cache connection or table error. | Check your application's default cache store. If it uses the `database` driver, make sure the Laravel cache table exists. |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lennart Fischer](https://github.com/Inventas)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
