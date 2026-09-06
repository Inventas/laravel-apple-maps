# Upgrade Guide

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
