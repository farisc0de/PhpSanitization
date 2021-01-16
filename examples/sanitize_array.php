<?php

$output = $sanitizer->useSanitize([
    "<script>alert('This is an array');</script>"
]);

foreach ($output as $single) {
    echo $single;
}
