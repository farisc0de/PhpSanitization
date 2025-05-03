<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Original text
$originalText = "This is a Text with 123 numbers and special ch@racters!";
echo "<h3>Original Text:</h3>";
echo "$originalText<br><br>";

// Since usePregReplace is now private, we demonstrate regex pattern replacement
// using callbacks and PHP's native functions
echo "<h3>Regular Expression Examples:</h3>";

// Example 1: Remove capital words
$result1 = $sanitizer->callback(function($str) {
    return preg_replace('/([A-Z])\w+/', '', $str);
}, $originalText);

echo "Example 1 - Remove capital words: $result1<br><br>";

// Example 2: Replace numbers with [NUM]
$result2 = $sanitizer->callback(function($str) {
    return preg_replace('/\d+/', '[NUM]', $str);
}, $originalText);

echo "Example 2 - Replace numbers: $result2<br><br>";

// Example 3: Replace special characters
$result3 = $sanitizer->callback(function($str) {
    return preg_replace('/[^a-zA-Z0-9\s]/', '*', $str);
}, $originalText);

echo "Example 3 - Replace special characters: $result3<br><br>";

// Example 4: Complex pattern matching
$emailText = "Contact us at info@example.com or support@company.org";
echo "<h3>Email Extraction:</h3>";
echo "Original: $emailText<br>";

$result4 = $sanitizer->callback(function($str) {
    // Extract email addresses
    preg_match_all('/[\w._%+-]+@[\w.-]+\.[\w]{2,6}/', $str, $matches);
    return "Extracted emails: " . implode(", ", $matches[0]);
}, $emailText);

echo "$result4<br>";

