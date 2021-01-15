# PhpSanitization

![](https://img.shields.io/packagist/l/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/dt/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/php-v/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/stars/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/v/phpsanitization/phpsanitization)

## About

Simple PHP Sanitization Class

Support String, Arrays, and Associative Arrays

## Features

1. Out-Of-The-Box
2. Support String, Arrays, and Associative Arrays
3. Escape PDO and SQL queries
4. Easy to Use

## How to install

```sh
$ composer require phpsanitization/phpsanitization
```

## Usage

### With Constructor

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$s = new Sanitization("<script>alert('xss');</script>");

echo $s->esc();
```

### Without Constructor

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$s = new Sanitization();

echo $s->esc("<script>alert('xss');</script>");
```

## Documentation

The documentation for PhpSanitization is available [here](https://fariscode511.github.io/PhpSanitization/)

## Changelog

Please have a look at [`CHANGELOG.md`](CHANGELOG.md).

## Code of Conduct

Please have a look at [`CODE_OF_CONDUCT.md`](.github/CODE_OF_CONDUCT.md).

## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE.md`](LICENSE.md).

## Copyright

Copyright (c) FarisCode - 2021
