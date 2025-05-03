<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Escape a SQL query to prevent SQL injection
$result = $sanitizer->useEscape("SELECT * FROM `users` WHERE `username` = 'admin'");
echo $result; // Will output the SQL with properly escaped quotes
