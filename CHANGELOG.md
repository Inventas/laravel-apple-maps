# Changelog

All notable changes to `laravel-apple-maps` will be documented in this file.

## 2.0.0 - 2026-09-06

### Changed

- Require PHP 8.2 or later and a secure Laravel 12.61.1+ or Laravel 13.12+ release.
- Upgrade from Saloon 3 to Saloon 4 and require Saloon's Laravel plugin 5.
- Support Testbench 10 and 11 and Pest 3, 4, and 5 across the supported PHP and Laravel versions.
- Test Laravel 12 and 13 on PHP 8.2 through 8.5, on Linux and Windows, with the lowest and newest dependency sets.

### Fixed

- Make the test suite independent of Apple Maps credentials and ignored Saloon recordings.
- Use Saloon 4-compatible mock responses for token, geocoding, and reverse-geocoding tests.

### Security

- Remove Laravel 11 support because no Laravel 11 release contains the current framework security fixes.
- Remove the obsolete PHPUnit configuration backup that contained embedded credentials.

See [UPGRADE.md](UPGRADE.md) for the 1.x to 2.0 migration steps.
