<?php

$output = $sanitizer->useSanitize([
    "xss" => "<script>alert('This is an associative array');</script>"
]);

foreach ($output as $key => $value) {
    echo "(" . $key . ": " . $value . ")";
}
