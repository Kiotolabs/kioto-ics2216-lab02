<?php
// router.php - optional router for PHP's built-in server.
// Usage: php -S localhost:8000 router.php
// It blocks direct downloads of files inside data/ (the database).
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if (str_starts_with($uri, '/data/')) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Forbidden\n";
    return true;
}

$file = __DIR__ . $uri;
if ($uri !== '/' && is_file($file)) {
    return false; // let the built-in server serve the static file
}

// Fall back to index.php if present, otherwise 404.
if (is_file(__DIR__ . '/index.php')) {
    require __DIR__ . '/index.php';
    return true;
}
return false;