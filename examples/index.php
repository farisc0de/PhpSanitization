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

    <p><b>Output:</b> <?php include_once './sanitize_string_example.php'; ?></p>

    <h2>Sanitize Array:</h2>

    <p><b>Output:</b> <?php include_once './sanitize_array_example.php'; ?></p>

    <h2>Sanitize Associative Array:</h2>

    <p><b>Output:</b> <?php include_once './sanitize_associative_array_example.php'; ?></p>

    <h2>Escape SQL Queries:</h2>

    <p><b>Output:</b> <?php include_once './escape_sql_query_example.php'; ?></p>

    <h2>useTrim Function:</h2>

    <p><b>Output:</b> <?php include_once './use_trim_example.php'; ?></p>

    <h2>useHtmlEntities Function:</h2>

    <p><b>Output:</b> <?php include_once './use_html_entities_example.php'; ?></p>

    <h2>useFilterVar Function:</h2>

    <p><b>Output:</b> <?php include_once './use_filter_var_example.php'; ?></p>

    <h2>useStripTags Function:</h2>

    <p><b>Output:</b> <?php include_once './use_strip_tags_example.php'; ?></p>

    <h2>useStripSlashes Function:</h2>

    <p><b>Output:</b> <?php include_once './use_strip_slashes_example.php'; ?></p>

    <h2>useHtmlSpecialChars Function:</h2>

    <p><b>Output:</b> <?php include_once './use_html_special_chars_example.php'; ?></p>

    <h2>setData Function:</h2>

    <p><b>Output:</b> <?php include_once './data_setter_example.php'; ?></p>

    <h2>getData Function:</h2>

    <p><b>Output:</b> <?php include_once './data_getter_example.php'; ?></p>

    <h2>useStrReplace Function:</h2>

    <p><b>Output:</b> <?php include_once './str_replace_example.php'; ?></p>

    <h2>usePregReplace Function:</h2>

    <p><b>Output:</b> <?php include_once './preg_replace_example.php'; ?></p>

    <h2>validateEmail Function:</h2>

    <p><b>Output:</b> <?php include_once './email_validate_example.php'; ?></p>

    <h2>isValid Function:</h2>

    <p><b>Output:</b> <?php include_once './is_valid_example.php'; ?></p>

    <h2>isEmpty Function:</h2>

    <p><b>Output:</b> <?php include_once './is_empty_example.php'; ?></p>

    <h2>isAssociative Function:</h2>

    <p><b>Output:</b> <?php include_once './is_associative_exmaple.php'; ?></p>
</body>

</html>