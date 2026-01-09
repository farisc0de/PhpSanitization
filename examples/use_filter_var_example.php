<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

echo "<h3>Using useFilterVar directly:</h3>";

// 1. Filter and sanitize a string
$string = "Hello <b>World</b>";
echo "<strong>Original string:</strong> " . htmlspecialchars($string) . "<br>";
echo "<strong>Filtered string:</strong> " . $sanitizer->useFilterVar($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "<br><br>";

// 2. Validate and filter an email
$email = "user@example.com";
echo "<strong>Email:</strong> $email<br>";
echo "<strong>Validated email:</strong> " . ($sanitizer->useFilterVar($email, FILTER_VALIDATE_EMAIL) ?: "Invalid") . "<br><br>";

// 3. Validate an integer
$number = "42";
echo "<strong>Number string:</strong> $number<br>";
echo "<strong>Validated integer:</strong> " . $sanitizer->useFilterVar($number, FILTER_VALIDATE_INT) . "<br><br>";

// 4. Validate a float
$float = "3.14";
echo "<strong>Float string:</strong> $float<br>";
echo "<strong>Validated float:</strong> " . $sanitizer->useFilterVar($float, FILTER_VALIDATE_FLOAT) . "<br><br>";

// 5. Validate a URL
$url = "https://github.com/farisc0de";
echo "<strong>URL:</strong> $url<br>";
echo "<strong>Validated URL:</strong> " . ($sanitizer->useFilterVar($url, FILTER_VALIDATE_URL) ?: "Invalid") . "<br><br>";

// 6. Sanitize with options
$ipAddress = "192.168.1.1";
echo "<strong>IP Address:</strong> $ipAddress<br>";
echo "<strong>Validated IP:</strong> " . ($sanitizer->useFilterVar($ipAddress, FILTER_VALIDATE_IP) ?: "Invalid") . "<br>";

