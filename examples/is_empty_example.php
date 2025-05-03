<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Utils;

// Create the Utils instance directly
$utils = new Utils();

// Test different types of values for emptiness
$nonEmptyString = "this is a text";
$emptyString = "";
$whitespaceString = "   \t  \n";
$emptyArray = [];
$nonEmptyArray = [1, 2, 3];

// Check each value type
echo "Non-empty string: " . ($utils->isEmpty($nonEmptyString) ? "empty" : "not empty") . "<br>";
echo "Empty string: " . ($utils->isEmpty($emptyString) ? "empty" : "not empty") . "<br>";
echo "Whitespace string: " . ($utils->isEmpty($whitespaceString) ? "empty" : "not empty") . "<br>";
echo "Empty array: " . ($utils->isEmpty($emptyArray) ? "empty" : "not empty") . "<br>";
echo "Non-empty array: " . ($utils->isEmpty($nonEmptyArray) ? "empty" : "not empty") . "<br>";

