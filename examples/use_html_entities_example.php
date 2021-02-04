<?php

echo $sanitizer->useHtmlEntities("<script>alert('This is js code');</script>");
