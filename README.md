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

```
composer require phpsanitization/phpsanitization
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
## License

This project is distributed under the MIT license

## Copyright

Copytighy (c) FarisCode - 2021
