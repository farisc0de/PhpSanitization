<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Sanitize a string with potential XSS payload
$result = $sanitizer->useSanitize("<script>alert('This is a string');</script>");
echo $result; // Will output the sanitized string with HTML entities
