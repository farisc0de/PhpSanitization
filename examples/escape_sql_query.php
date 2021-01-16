<?php

echo $sanitizer->useEscape("SELECT * FROM 'users' WHERE username = 'admin';");
