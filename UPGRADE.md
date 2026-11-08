# Upgrade Guide

## Upgrade from 2.x to 3.0

### Enable the HTTP routes if you use them

The package no longer registers `/api/v1/apple-maps/token`, `/api/v1/apple-maps/geocode` and `/api/v1/apple-maps/annotation/preview` by default. If your application calls these routes, add this variable and protect the routes with authentication middleware through `api_middleware`:

```dotenv
APPLE_MAPS_ROUTES=true
```

If you published `config/apple-maps.php`, add the new `routes` and `token_origin` keys from the package's config file.

### Restrict MapKit JS tokens

Tokens from the token route and `AppleMaps::getIntermediateToken()` work on any website unless they carry an origin. Set `APPLE_MAPS_TOKEN_ORIGIN` to your site's origin, such as `https://example.com`.

## Upgrade from 1.x to 2.0

Version 2.0 updates the package to Saloon 4 and removes Laravel 11 support. The package's public PHP API is unchanged.

### Requirements

- PHP 8.2 or later
- Laravel 12.61.1 or later, or Laravel 13.12 or later
- Saloon 4
- Saloon Laravel plugin 5

### Update the package

First, update other dependencies that require Saloon 3. Remove Composer inline aliases that present Saloon 4 as Saloon 3. Then run:

```bash
composer require inventas/laravel-apple-maps:^2.0 --with-all-dependencies
```

Existing calls to the `AppleMaps` facade, `AppleMaps` client, connector, and request classes do not need changes.

### Update Saloon test fixtures

Saloon 4 fixture names only accept letters, numbers, hyphens, slashes, and underscores. Periods are not valid. If application tests use this package's requests with a name such as `geocode.berlin`, change the name or replace the recording with `MockResponse::make()`.

For example:

```php
MockResponse::make([
    'results' => [],
]);
```
