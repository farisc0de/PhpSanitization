<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Example 1: Simple callback that returns the input value
echo "<h3>Example 1: Simple callback</h3>";
$result1 = $sanitizer->callback(function ($value) {
    return $value;
}, "This is a value");
echo "Result: $result1<br><br>";

// Example 2: Callback that modifies data and returns it
echo "<h3>Example 2: Process data with callback</h3>";
$result2 = $sanitizer->callback(function ($data) {
    // First sanitize the data
    $sanitized = strip_tags($data);
    // Then transform it to uppercase
    return strtoupper($sanitized);
}, "<p>This text will be <b>sanitized</b> and uppercased</p>");
echo "Result: $result2<br><br>";

// Example 3: Callback with no parameters
echo "<h3>Example 3: Callback without parameters</h3>";
$result3 = $sanitizer->callback(function () {
    return "Generated at: " . date('Y-m-d H:i:s');
});
echo "Result: $result3<br><br>";

// Example 4: Method chaining with callback
echo "<h3>Example 4: Method chaining</h3>";
try {
    $result4 = $sanitizer
        ->setData("<script>alert('XSS');</script>")
        ->useSanitize();
    
    echo "Sanitized data: $result4<br>";
    
    // Process the result with a callback
    $processed = $sanitizer->callback(function ($data) {
        return "Processed result: {$data}";
    }, $result4);
    
    echo "$processed<br>";
} catch (\InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}

