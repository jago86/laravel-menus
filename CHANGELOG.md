# Changelog

All Notable changes to `laravel-menus` will be documented in this file.

## Next

## 8.0.0 - 2026-06-26

### Added

- Laravel 12 and 13 support

### Changed

- Minimum PHP version is now 8.2
- `MenusServiceProvider` now implements `Illuminate\Contracts\Support\DeferrableProvider` (the old `$defer` property has been ignored by Laravel since 5.8)

### Removed

- Dropped the `laravelcollective/html` dependency. The HTML attribute rendering used by `MenuItem` is now built in. As a consequence, this package no longer registers the global `HTML` and `Form` aliases; if your application relies on them, require `laravelcollective/html` (or an equivalent) directly.
- Dropped support for PHP < 8.2 and Laravel < 12

## 6.0.0 - 2020-11-11

### Added

- Laravel 8 support

## 5.0.0 - 2019-10-01

### Added

- laravel 6.0 support

## 4.0.0 - 2019-10-01

### Added

- laravel 5.8 support

## 3.0.0 - 2018-09-30

### Added

- laravel 5.7 support

## 2.0.0 - 2018-02-14

### Added

- Laravel 5.6 support

### Removed

- Php 5.6 and 7.0

## 1.0.0 - 2017-09-01

### Added

- Support laravel 5.5
- Dropping php 5.6 support

## 0.5.0 - 2017-09-01

### Added

- Added a Zurb Foundation menu presenter
- Added a AdminLTE menu presenter
- More tests
- Changelog file
