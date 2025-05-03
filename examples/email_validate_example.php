<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Basic email validation (uses default provider list and DNS checking)
$result1 = $sanitizer->validateEmail("example@gmail.com");
echo "Basic validation: ";
echo $result1 ? "Valid" : "Invalid";
echo "<br>";

// Email validation with custom provider list
$customProviders = ['company.com', 'myorg.org'];
$result2 = $sanitizer->validateEmail("user@company.com", $customProviders);
echo "Custom provider validation: ";
echo $result2 ? "Valid" : "Invalid";
echo "<br>";

// Email validation without DNS checking (useful for testing)
$result3 = $sanitizer->validateEmail("test@example.com", [], false);
echo "Validation without DNS checking: ";
echo $result3 ? "Valid" : "Invalid";
