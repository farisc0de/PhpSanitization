<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Since useFilterVar is now private, we'll use useSanitize with different inputs
// to demonstrate the filter functionality

echo "<h3>Sanitizing Different Input Types:</h3>";

// 1. Sanitize string with potential XSS
$xssString = "<script>alert('XSS attack');</script>";
echo "<strong>Original string with XSS:</strong> ";
echo "<pre>" . htmlspecialchars($xssString) . "</pre>";
echo "<strong>Sanitized string:</strong> ";
echo "<pre>" . $sanitizer->useSanitize($xssString) . "</pre><br>";

// 2. Sanitize email address
$email = "user@example.com";
echo "<strong>Email validation:</strong> ";
echo $sanitizer->validateEmail($email) ? "Valid email" : "Invalid email";
echo "<br><br>";

// 3. Sanitize a URL
$url = "https://example.com/page?param=value&id=123";
echo "<strong>Original URL:</strong> $url<br>";
echo "<strong>Sanitized URL:</strong> " . $sanitizer->useSanitize($url) . "<br><br>";

// 4. Demonstrate the filtering of various types
$inputs = [
    'text' => "Hello <b>World</b>",
    'number' => "42",
    'float' => "3.14",
    'email' => "contact@example.com",
    'url' => "https://github.com/farisc0de"
];

echo "<strong>Filtering various inputs:</strong><br>";
foreach ($inputs as $type => $value) {
    echo "$type: " . $sanitizer->useSanitize($value) . "<br>";
}

