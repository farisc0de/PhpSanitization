
<p align="center">
    <img align="center" src="https://d.top4top.io/p_1862a8k1e1.png" height="350px" />
</p>

# PhpSanitization

![1](https://img.shields.io/packagist/l/phpsanitization/phpsanitization) ![2](https://img.shields.io/packagist/dt/phpsanitization/phpsanitization) ![3](https://img.shields.io/packagist/php-v/phpsanitization/phpsanitization) ![4](https://img.shields.io/packagist/v/phpsanitization/phpsanitization) [![6](https://codecov.io/gh/fariscode511/PhpSanitization/branch/main/graph/badge.svg?token=14M6FFMGV1)](https://codecov.io/gh/fariscode511/PhpSanitization)
[![7](https://app.fossa.com/api/projects/git%2Bgithub.com%2Ffariscode511%2FPhpSanitization.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Ffariscode511%2FPhpSanitization?ref=badge_shield)


## About

Simple PHP Sanitization Class

This is a simple class that can verify and clean values to assure they are valid.

It can take a given string and remove or encode certain types of text values, so it can be displayed in Web pages lowering the risk of being used to perform security attacks.

The class can also sanitize arrays of data by processing the array values one by one.

## Features

1. Out-Of-The-Box
2. Support String, Arrays, and Associative Arrays
3. Escape PDO and SQL queries
4. Sanitize and validate email
5. Built-in methods for custom sanitization
6. Easy to Use

## Requirements

1. PHP 7.0+
2. [Composer](https://getcomposer.org/)

## How to install

```sh
$ composer require phpsanitization/phpsanitization
```

## Usage

### Class Inclusion

```php
include_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;

$sanitizer = new Sanitization();
```

### useSanitize

```php
echo $sanitizer->useSanitize("<script>alert('xss');</script>");
```

### useEscape

```php
echo $sanitizer->useEscape("SELECT * FROM `users` WHERE `username` = 'admin';");
```

### useTrim

```php
echo $sanitizer->useTrim(" This is a text ");
```

### useHtmlEntities

```php
echo $sanitizer->useHtmlEntities("<script>alert('This is js code');</script>");
```

### useFilterVar

```php
echo $sanitizer->useFilterVar("This is a string");
```

### useStripTags

```php
echo $sanitizer->useStripTags("<script>alert('This is js code');</script>");
```

### useStripSlashes

```php
echo $sanitizer->useStripSlashes("C:\Users\Faris\Music");
```

### useHtmlSpecialChars

```php
echo $sanitizer->useHtmlSpecialChars("<script>alert('This is js code');</script>");
```

### setData

```php
$sanitizer->setData("This is data");
```

### getData

```php
echo $sanitizer->getData();
```

### useStrReplace

```php
echo $sanitizer->useStrReplace("text", "", "this is a text");
```

### usePregReplace

```php
echo $sanitizer->usePregReplace("/([A-Z])\w+/", "This is a Text");
```

### validateEmail

```php
echo $sanitizer->validateEmail("fake.email@gmail.com") ? "true" : "false";
```

### isValid

```php
echo $sanitizer->isValid("127.0.0.1", FILTER_VALIDATE_IP) ? "true" : "false";
```

### isEmpty

```php
echo $sanitizer->isEmpty($variable) ? "true" : "false";
```

### isAssociative

```php
echo $sanitizer->isAssociative($array) ? "true" : "fale";
```

## Screenshot

![Screenshot](https://f.top4top.io/p_1862u2uul1.png)

## Documentation

The documentation for PhpSanitization is available [here](https://fariscode511.github.io/PhpSanitization/)

## Changelog

Please have a look at [`CHANGELOG.md`](CHANGELOG.md).

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CODE_OF_CONDUCT.md`](.github/CODE_OF_CONDUCT.md).

## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE.md`](LICENSE.md).


[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Ffariscode511%2FPhpSanitization.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Ffariscode511%2FPhpSanitization?ref=badge_large)

## Copyright

[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)](https://github.com/ellerbrock/open-source-badge/)

Copyright (c) FarisCode - 2021
