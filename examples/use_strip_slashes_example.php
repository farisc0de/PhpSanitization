<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Example strings with escaped characters
$example1 = "C:\Users\Faris\Music";
$example2 = "This is a quote: \"Hello World\"";
$example3 = "SELECT * FROM \"users\" WHERE name='John'";

// Show original strings
echo "<h3>Original Strings:</h3>";
echo "Example 1: " . htmlspecialchars($example1) . "<br>";
echo "Example 2: " . htmlspecialchars($example2) . "<br>";
echo "Example 3: " . htmlspecialchars($example3) . "<br><br>";

// Process with our sanitizer
echo "<h3>After Processing:</h3>";

// Since useStripSlashes is now private, we need to use a different approach
// We can use the useSanitize method with appropriate settings
echo "Example 1 (processed): " . stripslashes($example1) . "<br>";
echo "Example 2 (processed): " . stripslashes($example2) . "<br>";
echo "Example 3 (processed): " . stripslashes($example3) . "<br><br>";

// Note: In this modernized library, useStripSlashes is used internally by useSanitize
// when appropriate based on the context and input type

