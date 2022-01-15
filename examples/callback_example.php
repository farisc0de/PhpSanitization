<?php

$text = $sanitizer->callback(function ($value) {
    return $value;
}, "This is a value");

echo $text;
