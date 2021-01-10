# PhpSanitization
Simple PHP Sanitization Class

Support String, Arrays, and Associative Arrays

## Usage

### With Constructor
```php
include_once 'Sanitization.php';

$s = new Sanitization("<script>alert('xss');</script>");

echo $s->esc();
```

### Without Constructor
```php
include_once 'Sanitization.php';

$s = new Sanitization();

echo $s->esc("<script>alert('xss');</script>");
```


## Copyright

FarisCode
