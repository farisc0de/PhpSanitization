<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/TrimDirection.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\TrimDirection;
use PhpSanitization\PhpSanitization\Utils;

$sanitizer = new Sanitization(new Utils());

// Trim from both sides (default)
$result = $sanitizer->useTrim(" This is a text ");
echo $result . "\n"; // Output: This is a text

// Trim from left only
$result = $sanitizer->useTrim(" This is a text ", TrimDirection::Left);
echo $result . "\n"; // Output: This is a text 

// Trim from right only
$result = $sanitizer->useTrim(" This is a text ", TrimDirection::Right);
echo $result . "\n"; // Output:  This is a text
