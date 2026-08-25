

<p align="center">
    <img align="center" src="https://d.top4top.io/p_1862a8k1e1.png" height="350px" />
</p>

# PhpSanitization

![](https://img.shields.io/github/license/farisc0de/PhpSanitization) ![](https://img.shields.io/github/v/tag/farisc0de/PhpSanitization) ![](https://img.shields.io/github/repo-size/farisc0de/PhpSanitization) ![](https://img.shields.io/github/languages/top/farisc0de/PhpSanitization)

## About

A modern, type-safe PHP sanitization library designed for security and efficiency.

PhpSanitization provides robust validation and sanitization capabilities to ensure your data is clean and safe. The library implements strict typing and leverages PHP 8's features for enhanced type safety and performance.

It can process strings, arrays (including deeply nested structures), and protect against various security threats like XSS and SQL injection.

## Features

1. **Strict Typing**: Full type declarations for all methods and parameters
2. **Enhanced Security**: Improved protections against XSS and SQL injection attacks
3. **Recursive Sanitization**: Deep cleaning of nested arrays and complex data structures
4. **Method Chaining**: Fluent interface for composing multiple operations
5. **Enhanced Email Validation**: DNS checking and custom provider validation
6. **Improved SQL Escaping**: Better protection using `strtr()` for more secure queries
7. **Comprehensive Documentation**: Complete examples for all features
8. **PHP 8 Features**: Utilizes union types and match expressions

## Requirements

1. PHP 8.0+
2. [Composer](https://getcomposer.org/)

## Installation & Usage

### Installation

```sh
$ composer require phpsanitization/phpsanitization
```

### Basic Setup

```php
<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize with proper dependency injection
$sanitizer = new Sanitization(new Utils());
```

## Core Features

### String Sanitization

```php
// Sanitize a string with potential XSS
$result = $sanitizer->useSanitize("<script>alert('xss');</script>");
echo $result; // Outputs safely encoded HTML entities
```

### Array Sanitization

```php
// Sanitize a simple array
$array = [
    "<script>alert('xss');</script>",
    "<a href='javascript:alert(\"click\")'>Click me</a>"
];
$result = $sanitizer->useSanitize($array);

// Sanitize an associative array
$assocArray = [
    "name" => "<script>alert('name');</script>",
    "url" => "<a href='javascript:alert(\"url\")'>URL</a>"
];
$result = $sanitizer->useSanitize($assocArray);
```

### Recursive Array Sanitization (New in v2.0)

```php
// Sanitize deeply nested structures
$nestedData = [
    'user' => [
        'name' => 'John <script>alert("XSS")</script> Doe',
        'settings' => [
            'theme' => 'dark<iframe src="malicious.html">'
        ]
    ]
];
$sanitizedData = $sanitizer->useSanitize($nestedData); // All levels sanitized!
```

### SQL Query Escaping

```php
// Escape a SQL query to prevent injection
$query = "SELECT * FROM `users` WHERE `username` = 'admin' OR 1=1--'";
$safeQuery = $sanitizer->useEscape($query);
```

### Enhanced Email Validation (Improved in v2.0)

```php
// Basic email validation with DNS checking
$isValid = $sanitizer->validateEmail("user@example.com");

// Email validation with custom provider list
$customProviders = ['company.com', 'organization.org'];
$isValid = $sanitizer->validateEmail("user@company.com", $customProviders);

// Email validation without DNS checking (for testing)
$isValid = $sanitizer->validateEmail("test@example.com", [], false);
```

### Method Chaining (New in v2.0)

```php
// Chain multiple operations together
$result = $sanitizer
    ->setData("<script>alert('XSS');</script>")
    ->useSanitize();
    
// Process with callback
$sanitizer
    ->setData("<p>Some content with <script>alert('danger');</script></p>")
    ->useSanitize();
    
$processed = $sanitizer->callback(function($data) {
    return "Processed: " . $data;
}, $sanitizer->getData());
```

### Utility Methods

```php
$utils = new Utils();

// Check if a variable is empty
$isEmpty = $utils->isEmpty($variable);

// Check if an array is associative
$isAssoc = $utils->isAssociative($array);

// Validate using filter_var
$isValidIP = $sanitizer->isValid("127.0.0.1", FILTER_VALIDATE_IP);
```

### Custom Processing with Callbacks

```php
// Use callbacks for custom processing
$result = $sanitizer->callback(function($data) {
    // Custom processing logic here
    return strtoupper($data) . " (processed)";
}, "input data");
```

## Running the Examples

The library includes a comprehensive set of examples demonstrating all features:

```sh
# Navigate to the examples directory
cd examples

# Run the examples using PHP's built-in server
php -S localhost:8000
```

Then visit `http://localhost:8000` in your browser to see all examples in action.

## Migration from v1.x to v2.0

Version 2.0 introduces several breaking changes to improve security and type safety:

1. **Strict typing** is now enforced with `declare(strict_types=1)`
2. **Private methods**: Several helper methods are now private (use public methods instead)
3. **Utils class separation**: Utility methods moved to a separate class
4. **Type declarations**: All methods now have parameter and return type declarations
5. **Method signatures**: Some method signatures have changed to support new features

If you're upgrading from 1.x, review the examples directory for guidance on updating your code.

## Documentation

Comprehensive documentation is available in the examples directory and in the source code. For full API documentation, visit [PhpSanitization Documentation](https://www.farisotaibi.com/PhpSanitization/).

## Changelog

Please see [`CHANGELOG.md`](CHANGELOG.md) for a detailed list of changes in each version.

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

Copyright (c) Faris Alotaibi - 2025
