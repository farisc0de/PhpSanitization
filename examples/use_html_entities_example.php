<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Since useHtmlEntities is now private, we can use useSanitize which calls it internally
// or we can demonstrate our direct HTML entity encoding with the ENT_HTML5 flag

// Create a string with potentially malicious HTML/JS content
$maliciousContent = "<script>alert('This is js code');</script>";

// Method 1: Using useSanitize (which uses useHtmlEntities internally)
echo "<h3>Using useSanitize:</h3>";
$result1 = $sanitizer->useSanitize($maliciousContent);
echo "Result: $result1<br>";
echo "<small>Notice how the tags are converted to HTML entities</small><br><br>";

// Method 2: Display the raw vs encoded content
echo "<h3>Raw vs Encoded comparison:</h3>";
echo "<strong>Raw content (dangerous!):</strong><br>";
echo "<pre>$maliciousContent</pre>";

echo "<strong>Encoded with useSanitize (safe):</strong><br>";
echo "<pre>$result1</pre>";
echo "<small>This safely displays the script tags without executing them</small><br>";

