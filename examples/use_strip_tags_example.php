<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Since useStripTags is now private, we'll use useSanitize with appropriate configurations
// or demonstrate alternative approaches

// Create a string with HTML/script tags
$htmlContent = "<p>This is <b>bold</b> text with a <script>alert('This is js code');</script></p>";

// Show the original content (safely escaped for display)
echo "<h3>Original Content:</h3>";
echo "<pre>" . htmlspecialchars($htmlContent) . "</pre><br>";

// Method 1: Using useSanitize (which internally uses appropriate methods)
echo "<h3>Using useSanitize:</h3>";
$result1 = $sanitizer->useSanitize($htmlContent);
echo "Result: " . $result1 . "<br><br>";

// Method 2: Using PHP's built-in strip_tags function for comparison
echo "<h3>Using PHP's built-in strip_tags:</h3>";
$result2 = strip_tags($htmlContent);
echo "Result: " . $result2 . "<br><br>";

// Note: Our library's implementation is more robust and secure than just using strip_tags
// as it combines multiple sanitization techniques

