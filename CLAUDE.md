# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`nwidart/laravel-menus` is a standalone Laravel package (not an application) for building and rendering navigation menus. It is consumed by other Laravel apps via Composer and is auto-discovered through the `extra.laravel` block in `composer.json` (provider `MenusServiceProvider`, facade alias `Menu`). PSR-4: `Nwidart\Menus\` → `src/`, `Nwidart\Menus\Tests\` → `Tests/`.

## Commands

```bash
composer install              # install deps (orchestra/testbench provides the Laravel test harness)
vendor/bin/phpunit            # run the full test suite
vendor/bin/phpunit --filter testMethodName   # run a single test
vendor/bin/php-cs-fixer fix   # apply code style fixes (config: .php-cs-fixer.dist.php)
vendor/bin/grumphp run        # run the pre-commit checks (php-cs-fixer + composer validate)
```

Tests run against `Tests/` (note the capitalized directory); coverage whitelist is `src/`. There is no separate build step — it's a library.

## Architecture

The rendering pipeline has three layers. Understanding how they hand off is the key to the codebase:

1. **`Menu`** (`src/Menu.php`, bound as the `menus` singleton and exposed via the `Menu` facade) — a registry. `Menu::create()/make()` instantiates a `MenuBuilder`, stores it by name, and runs the user's closure against it. `get()/render()` look the builder up by name and render it. The singleton holds all menus for the request.

2. **`MenuBuilder`** (`src/MenuBuilder.php`) — one per named menu. Holds the menu's `MenuItem` tree, the active presenter, URL prefix, and ordering flag. This is where menus are defined (`->url()`, `->route()`, `->dropdown()`, `->divider()`, etc.) and where `render()` walks the items and emits HTML. The default presenter is `Presenters\Bootstrap\NavbarPresenter`.

3. **`MenuItem`** (`src/MenuItem.php`) — a single node; supports nesting (dropdowns/submenus), attributes, ordering, and active-state detection.

**Presenters** (`src/Presenters/`) decide the markup. `PresenterInterface` defines the tag-wrapper hooks; `Presenter` is the abstract base with empty defaults; concrete presenters live under `Bootstrap/`, `Admin/` (AdminLTE), `Foundation/` (Zurb), and `Metronic/`. A menu can render with a presenter class, a named **style** (mapped in `config/config.php` under `styles`), or a Blade view template in `views/`. Presenters build HTML by string concatenation, pulling per-item attributes from `MenuItem::getAttributes()`, which renders the attribute string in-package (`attributesToHtml()`/`attributeElement()` in `src/MenuItem.php`) — there is no external HTML-builder dependency.

**Config** (`config/config.php`, merged under the `menus` key) maps style names → presenter classes and holds the global `ordering` flag. It is publishable to the host app as `config/menus.php`.

**Views** (`views/`) are Blade templates for view-based rendering; publishable to `resources/views/vendor/nwidart/menus`.

The service provider is **deferred** (implements `Illuminate\Contracts\Support\DeferrableProvider`, only provides `menus`). On boot it also auto-requires `app_path('Support/menus.php')` from the host app if present — that file is the conventional place for consumers to define their menus.

## Conventions

- Code style is enforced by php-cs-fixer via `.php_cs.dist`; run it (or grumphp) before committing.
- This is a multi-Laravel-version package — see the compatibility table in `README.md`. Keep changes compatible with the supported `illuminate/*` constraints in `composer.json` rather than assuming the latest Laravel.
