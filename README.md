# PhpSanitization
Simple PHP Sanitization Class

Support String, Arrays, and Associative Arrays

## How to install

```
composer require fariscode/phpsanitization
```

## Usage

### With Constructor
```php
include_once 'vendor/autoload.php';

use PhpSanitization\Sanitization;

$s = new Sanitization("<script>alert('xss');</script>");

echo $s->esc();
```

### Without Constructor
```php
include_once 'vendor/autoload.php';

use PhpSanitization\Sanitization;

$s = new Sanitization();

echo $s->esc("<script>alert('xss');</script>");
```

## Copyright

FarisCode
