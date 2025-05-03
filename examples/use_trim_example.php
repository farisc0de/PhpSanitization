<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Since useTrim is now private, we'll use the public useSanitize method instead
$sanitizer = new Sanitization(new Utils());

// Sanitize will trim the input as part of its process
$result = $sanitizer->useSanitize(" This is a text ");
echo $result; // Output: This is a text
