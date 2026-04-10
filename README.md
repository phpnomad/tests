# phpnomad/tests

[![Latest Version](https://img.shields.io/packagist/v/phpnomad/tests.svg)](https://packagist.org/packages/phpnomad/tests)
[![Total Downloads](https://img.shields.io/packagist/dt/phpnomad/tests.svg)](https://packagist.org/packages/phpnomad/tests)
[![PHP Version](https://img.shields.io/packagist/php-v/phpnomad/tests.svg)](https://packagist.org/packages/phpnomad/tests)
[![License](https://img.shields.io/packagist/l/phpnomad/tests.svg)](https://packagist.org/packages/phpnomad/tests)

`phpnomad/tests` is the shared PHPUnit base that PHPNomad packages use for their own unit tests. It provides a `TestCase` wired up with Mockery-PHPUnit integration and two reflection traits for reaching into protected or private state. If you're writing application code against PHPNomad, you don't need this package. If you're contributing to a PHPNomad package, its `tests/` directory almost certainly already depends on it.

## Installation

```bash
composer require --dev phpnomad/tests
```

Pull it in as a dev dependency only. It isn't meant for production code paths.

## What's included

- `PHPNomad\Tests\TestCase` extends `PHPUnit\Framework\TestCase` and mixes in `MockeryPHPUnitIntegration`, so Mockery expectations are verified and containers cleaned up automatically between tests.
- `PHPNomad\Tests\Traits\WithInaccessibleMethods` provides `callInaccessibleMethod()` for invoking protected or private methods through reflection.
- `PHPNomad\Tests\Traits\WithInaccessibleProperties` provides `getProtectedProperty()`, `getProtectedPropertyValue()`, and `setProtectedProperty()` for reading and writing protected or private properties through reflection.

## Usage pattern

Each PHPNomad package defines its own package-local `TestCase` that extends the shared one. That gives the package its own namespace root under `Tests/` while inheriting the PHPUnit and Mockery plumbing.

```php
<?php

namespace MyPackage\Tests;

use PHPNomad\Tests\TestCase as PHPNomadTestCase;

class TestCase extends PHPNomadTestCase
{
}
```

Concrete unit tests then extend the package-local `TestCase` and mix in whichever traits they need.

```php
<?php

namespace MyPackage\Tests\Unit;

use MyPackage\Services\WidgetBuilder;
use MyPackage\Tests\TestCase;
use PHPNomad\Tests\Traits\WithInaccessibleMethods;

class WidgetBuilderTest extends TestCase
{
    use WithInaccessibleMethods;

    public function testNormalizeHandlesEmptyInput(): void
    {
        $builder = new WidgetBuilder();

        $result = $this->callInaccessibleMethod($builder, 'normalize', '');

        $this->assertSame('', $result);
    }
}
```

## Documentation

Framework-wide documentation lives at [phpnomad.com](https://phpnomad.com).

## License

MIT. See [LICENSE.txt](LICENSE.txt).
