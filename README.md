# PhpSanitization
Simple PHP Sanitization Class

## Usage

```php
include_once 'Sanitization.php';

$s = new Sanitization("<script>alert('xss');</script>");

echo $s->esc();
```


## Copyright

FarisCode
