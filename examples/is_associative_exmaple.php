<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Utils;

$array = ["key" => "value"];

$utils = new Utils();

echo $utils->isAssociative($array) ? "true" : "false";
