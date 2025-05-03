<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Create a sequential array with potentially malicious content
$inputArray = [
    "<script>alert('xss');</script>", 
    "<a href=\"https://github.com/farisc0de\">XSS</a>"
];

// Sanitize the array
$result = $sanitizer->useSanitize($inputArray);

// Print the sanitized result
print_r($result);

foreach ($result as $single) {
    echo $single;
}
