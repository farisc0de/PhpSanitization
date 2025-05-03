<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Create a deeply nested array with various data types and potentially malicious content
$nestedData = [
    'user' => [
        'name' => 'John <script>alert("XSS")</script> Doe',
        'email' => 'john@example.com',
        'preferences' => [
            'theme' => 'dark<iframe src="malicious.html">',
            'notifications' => true,
            'settings' => [
                'privacy' => '<img src="x" onerror="alert(1)">' 
            ]
        ]
    ],
    'id' => 42,  // Numeric value
    'active' => true  // Boolean value
];

// Sanitize the entire nested structure
$sanitizedData = $sanitizer->useSanitize($nestedData);

// Output the results
echo "<h3>Original Data (Don't use this in production!):</h3>";
echo "<pre>";
print_r($nestedData);
echo "</pre>";

echo "<h3>Sanitized Data (Safe to use):</h3>";
echo "<pre>";
print_r($sanitizedData);
echo "</pre>";

echo "<p>Notice how only the string values containing HTML were sanitized, ";
echo "while numeric and boolean values were preserved.</p>";

echo "<p>The nested structure is also maintained, with all levels properly sanitized.</p>";
