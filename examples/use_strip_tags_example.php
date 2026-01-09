<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Create a string with HTML/script tags
$htmlContent = "<p>This is <b>bold</b> text with a <script>alert('This is js code');</script></p>";

// Show the original content (safely escaped for display)
echo "<h3>Original Content:</h3>";
echo "<pre>" . htmlspecialchars($htmlContent) . "</pre><br>";

// Using useStripTags directly - strip all tags
echo "<h3>Using useStripTags (strip all tags):</h3>";
$result1 = $sanitizer->useStripTags($htmlContent);
echo "Result: " . $result1 . "<br><br>";

// Using useStripTags with allowed tags
echo "<h3>Using useStripTags (allow &lt;b&gt; tags):</h3>";
$result2 = $sanitizer->useStripTags($htmlContent, '<b>');
echo "Result: " . $result2 . "<br><br>";

// Using useStripTags with multiple allowed tags
echo "<h3>Using useStripTags (allow &lt;p&gt; and &lt;b&gt; tags):</h3>";
$result3 = $sanitizer->useStripTags($htmlContent, '<p><b>');
echo "Result: " . $result3 . "<br>";

