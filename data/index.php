<?php
// Block directory browsing of the data/ folder.
http_response_code(403);
header('Content-Type: text/plain; charset=utf-8');
echo "Forbidden\n";