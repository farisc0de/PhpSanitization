<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Create an associative array with potentially malicious content
$inputArray = [
    "xss" => "<script>alert('This is an associative array');</script>",
    "html'injection" => "<iframe src=\"javascript:alert('XSS')\"></iframe>"
];

// Sanitize the associative array
$result = $sanitizer->useSanitize($inputArray);

// Print the sanitized result
echo "<pre>";
print_r($result);
echo "</pre>";

// Show each key-value pair
foreach ($result as $key => $value) {
    echo $key . " => " . $value . "<br>";
}
