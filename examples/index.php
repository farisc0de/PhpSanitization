<?php

include_once '../src/Sanitization.php';

use PhpSanitization\PhpSanitization\Sanitization;

$sanitizer = new Sanitization();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpSanitization Examples</title>
</head>

<body>
    <h1>PhpSanitization Examples</h1>

    <h2>Sanitize String:</h2>

    <p><b>Output:</b> <?php include_once './sanitize_string.php'; ?></p>

    <h2>Sanitize Array:</h2>

    <p><b>Output:</b> <?php include_once './sanitize_array.php'; ?></p>

    <h2>Sanitize Associative Array:</h2>

    <p><b>Output:</b> <?php include_once './sanitize_associative_array.php'; ?></p>

    <h2>Escape SQL Queries:</h2>

    <p><b>Output:</b> <?php include_once './escape_sql_query.php'; ?></p>
</body>

</html>