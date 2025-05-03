<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Basic data setting example
echo "<h3>Basic Data Setting:</h3>";
$sanitizer->setData("Lorem ipsum dolor sit amet.");
echo 'Data has been set to: ' . $sanitizer->getData() . '<br><br>';

// Demonstrate method chaining (new feature in the modernized library)
echo "<h3>Method Chaining:</h3>";

// Example 1: Set data and immediately sanitize it
$result1 = $sanitizer
    ->setData("<script>alert('XSS');</script>")
    ->useSanitize();

echo "Example 1 - Set and sanitize: " . $result1 . "<br><br>";

// Example 2: Multiple operations in a chain
$maliciousData = "<a href='javascript:alert(\"XSS\")'>Click me</a>";
echo "Original data: " . htmlspecialchars($maliciousData) . "<br>";

$result2 = $sanitizer
    ->setData($maliciousData)
    ->useSanitize();

echo "Sanitized with method chaining: " . $result2 . "<br><br>";

