<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Define test data
$tests = [
    'ip' => [
        'value' => '127.0.0.1',
        'filter' => FILTER_VALIDATE_IP
    ],
    'email' => [
        'value' => 'user@example.com',
        'filter' => FILTER_VALIDATE_EMAIL
    ],
    'url' => [
        'value' => 'https://github.com/farisc0de',
        'filter' => FILTER_VALIDATE_URL
    ],
    'int' => [
        'value' => '42',
        'filter' => FILTER_VALIDATE_INT
    ],
    'invalid_ip' => [
        'value' => '999.999.999.999',
        'filter' => FILTER_VALIDATE_IP
    ]
];

echo "<h3>Validation Examples:</h3>";
foreach ($tests as $type => $test) {
    // Use our modernized isValid method to check various inputs
    $result = $sanitizer->isValid($test['value'], $test['filter']);
    echo "Validating $type ({$test['value']}): " . ($result ? "<span style='color:green'>Valid</span>" : "<span style='color:red'>Invalid</span>") . "<br>";
}

// Example of using the enhanced email validation instead
echo "<h3>Enhanced Email Validation:</h3>";
$emailToCheck = "user@example.com";
$result = $sanitizer->validateEmail($emailToCheck);
echo "Validating email ($emailToCheck) with DNS check: " . ($result ? "<span style='color:green'>Valid</span>" : "<span style='color:red'>Invalid</span>") . "<br>";

// Demonstrate with custom providers
$customProviders = ['example.com', 'github.com'];
$result2 = $sanitizer->validateEmail($emailToCheck, $customProviders);
echo "Validating with custom providers: " . ($result2 ? "<span style='color:green'>Valid</span>" : "<span style='color:red'>Invalid</span>") . "<br>";

