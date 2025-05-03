<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Original string
$originalString = "this is a text with some unwanted text";
echo "<h3>Original String:</h3>";
echo "$originalString<br><br>";

// Since useStrReplace is now private, we can demonstrate string replacement
// using method chaining and callback
echo "<h3>String Replacement Examples:</h3>";

// Example 1: Basic replacement using callback
$result1 = $sanitizer->callback(function($str) {
    return str_replace("text", "content", $str);
}, $originalString);

echo "Example 1 - Replace 'text' with 'content': $result1<br><br>";

// Example 2: Multiple replacements
$result2 = $sanitizer->callback(function($str) {
    // Replace multiple things at once
    return str_replace(
        ["this", "is", "text"], 
        ["that", "was", "content"], 
        $str
    );
}, $originalString);

echo "Example 2 - Multiple replacements: $result2<br><br>";

// Example 3: Using method chaining for data processing
$result3 = $sanitizer
    ->setData("<script>alert('dangerous text');</script>")
    ->useSanitize();

// Now further process the result with a callback
$cleanedResult = $sanitizer->callback(function($str) {
    return str_replace("dangerous", "safe", $str);
}, $result3);

echo "Example 3 - Sanitize then replace: $cleanedResult<br>";

