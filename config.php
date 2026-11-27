<?php
// config.php - shared settings. Students may edit these three values.
const DB_FILE    = __DIR__ . '/data/portfolio.db'; // the SQLite database file
const PROFILE_ID = 1;                              // your row in the profile table
const ADMIN_PASS = 'change-me-please';             // password for admin.php

function db(): PDO {
    // Make sure the data/ folder exists so a fresh copy of the starter works
    // even if the student forgot to create it (common on first run).
    $dir = dirname(DB_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    $pdo = new PDO('sqlite:' . DB_FILE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}
function h(?string $s): string { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
