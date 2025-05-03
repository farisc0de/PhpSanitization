<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Create a string with HTML and special characters
$htmlContent = "<script>alert('This is js code');</script>";

// Display the original content (safely)
echo "<h3>Original Content:</h3>";
echo "<pre>" . htmlspecialchars($htmlContent) . "</pre><br>";

// Since useHtmlSpecialChars is now private, we use useSanitize
echo "<h3>Using Sanitizer:</h3>";
$result = $sanitizer->useSanitize($htmlContent);
echo "Result: $result<br><br>";

// Compare with native PHP function
echo "<h3>Using PHP's htmlspecialchars:</h3>";
$phpResult = htmlspecialchars($htmlContent, ENT_QUOTES | ENT_HTML5);
echo "Result: $phpResult<br><br>";

// Note the differences between the two:  
// 1. Our sanitizer handles more security concerns
// 2. It uses ENT_HTML5 for better security
// 3. It combines multiple sanitization techniques
