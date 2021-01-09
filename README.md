# PhpSanitization
Simple PHP Sanitization Class

Support String, Arrays, and Associative Arrays

## Usage

```php
include_once 'Sanitization.php';

$s = new Sanitization("<script>alert('xss');</script>");

echo $s->esc();
```


## Copyright

FarisCode
