<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Utils.php';
require_once __DIR__ . '/../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;
use PhpSanitization\PhpSanitization\Utils;

// Initialize the sanitizer with the Utils dependency
$sanitizer = new Sanitization(new Utils());

// Set some data first so we have something to retrieve
$sanitizer->setData("This is sample data set with setData() method");

// Basic usage of getData
echo "<h3>Basic getData() usage:</h3>";
echo "Retrieved data: " . $sanitizer->getData() . "<br><br>";

// Demonstrate the type-safety of our modernized library
echo "<h3>Type safety demonstration:</h3>";

// Set different types of data
$sanitizer->setData("<b>HTML string</b>");
echo "HTML string: " . $sanitizer->getData() . "<br>";

$sanitizer->setData([1, 2, 3, 4, 5]);
echo "Array data: ";
print_r($sanitizer->getData());
echo "<br><br>";

// Demonstrate chained method calls
echo "<h3>Method chaining:</h3>";
echo $sanitizer
    ->setData("<script>alert('getData works!');</script>")
    ->useSanitize();

