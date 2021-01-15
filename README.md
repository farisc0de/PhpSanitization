# PhpSanitization

![](https://img.shields.io/packagist/l/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/dt/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/php-v/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/stars/phpsanitization/phpsanitization) ![](https://img.shields.io/packagist/v/phpsanitization/phpsanitization) ![](https://img.shields.io/github/workflow/status/fariscode511/PhpSanitization/CI%20(Build%20&%20Test))

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

### Sanitize Values

#### With Constructor

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$s = new Sanitization("<script>alert('xss');</script>");

echo $s->useSanitize();
```

#### Without Constructor

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$s = new Sanitization();

echo $s->useSanitize("<script>alert('xss');</script>");
```

#### Output

```html
&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;
```

### Escape SQL

#### With Constructor

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$s = new Sanitization("SELECT * FROM 'users' WHERE username = 'admin';");

echo $s->useEscape();
```

#### Without Constructor

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$s = new Sanitization();

echo $s->useEscape("SELECT * FROM 'users' WHERE username = 'admin';");
```

#### Output
```sql
SELECT * FROM \'users\' WHERE username = \'admin\';
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

[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)](https://github.com/ellerbrock/open-source-badge/)    

Copyright (c) FarisCode - 2021
