<?php

echo $sanitizer->isValid("127.0.0.1", FILTER_VALIDATE_IP) ? "true" : "false";
