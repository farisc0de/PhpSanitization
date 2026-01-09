<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Create a string with potentially malicious HTML/JS content
$maliciousContent = "<script>alert('This is js code');</script>";

// Using useHtmlEntities directly
echo "<h3>Using useHtmlEntities:</h3>";
$result = $sanitizer->useHtmlEntities($maliciousContent);
echo "Result: $result<br>";
echo "<small>Notice how the tags are converted to HTML entities</small><br><br>";

// Display the raw vs encoded content
echo "<h3>Raw vs Encoded comparison:</h3>";
echo "<strong>Raw content (dangerous!):</strong><br>";
echo "<pre>" . htmlspecialchars($maliciousContent) . "</pre>";

echo "<strong>Encoded with useHtmlEntities (safe):</strong><br>";
echo "<pre>$result</pre>";
echo "<small>This safely displays the script tags without executing them</small><br><br>";

// Using different quote styles
echo "<h3>Different quote styles:</h3>";
$quoteContent = "He said \"Hello\" and 'Goodbye'";
echo "<strong>Original:</strong> $quoteContent<br>";
echo "<strong>ENT_QUOTES:</strong> " . $sanitizer->useHtmlEntities($quoteContent, ENT_QUOTES) . "<br>";
echo "<strong>ENT_NOQUOTES:</strong> " . $sanitizer->useHtmlEntities($quoteContent, ENT_NOQUOTES) . "<br>";

