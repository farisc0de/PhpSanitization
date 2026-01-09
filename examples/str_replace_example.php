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

echo "<h3>String Replacement Examples:</h3>";

// Example 1: Basic replacement using useStrReplace
$result1 = $sanitizer->useStrReplace("text", "content", $originalString);
echo "Example 1 - Replace 'text' with 'content': $result1<br><br>";

// Example 2: Multiple replacements with arrays
$result2 = $sanitizer->useStrReplace(
    ["this", "is", "text"], 
    ["that", "was", "content"], 
    $originalString
);
echo "Example 2 - Multiple replacements: $result2<br><br>";

// Example 3: Replace in an array of strings
$strings = ["Hello World", "Hello PHP", "Hello Sanitization"];
$result3 = $sanitizer->useStrReplace("Hello", "Hi", $strings);
echo "Example 3 - Replace in array:<br>";
foreach ($result3 as $str) {
    echo "- $str<br>";
}

