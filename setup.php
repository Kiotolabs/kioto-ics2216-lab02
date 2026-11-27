<?php
// setup.php - run ONCE in the browser to create the tables (skip if you already
// copied your own portfolio.db into the data/ folder).
require __DIR__ . '/config.php';

try {
    $pdo = db();
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS profile (profile_id INTEGER PRIMARY KEY, full_name TEXT NOT NULL, programme TEXT, bio TEXT);
        CREATE TABLE IF NOT EXISTS skill (skill_id INTEGER PRIMARY KEY, profile_id INTEGER NOT NULL, skill_name TEXT NOT NULL, level TEXT, FOREIGN KEY (profile_id) REFERENCES profile(profile_id));
        CREATE TABLE IF NOT EXISTS hobby (hobby_id INTEGER PRIMARY KEY, profile_id INTEGER NOT NULL, hobby_name TEXT NOT NULL, description TEXT, FOREIGN KEY (profile_id) REFERENCES profile(profile_id));
        CREATE TABLE IF NOT EXISTS movie (movie_id INTEGER PRIMARY KEY, profile_id INTEGER NOT NULL, title TEXT NOT NULL, release_year INTEGER, my_rank INTEGER, why_i_love_it TEXT, FOREIGN KEY (profile_id) REFERENCES profile(profile_id));
        CREATE TABLE IF NOT EXISTS enquiry (enquiry_id INTEGER PRIMARY KEY, profile_id INTEGER NOT NULL, sender_name TEXT NOT NULL, sender_email TEXT NOT NULL, message TEXT NOT NULL, sent_at TEXT DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (profile_id) REFERENCES profile(profile_id));
    ");

    if ((int)$pdo->query('SELECT COUNT(*) AS c FROM profile')->fetch()['c'] === 0) {
        $pdo->exec("INSERT INTO profile (full_name, programme, bio) VALUES ('Your Name', 'BSc. Fisheries and Aquaculture', 'Edit me in DB Browser for SQLite')");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setup complete</title><link rel="stylesheet" href="style.css"></head><body>
    <main style="max-width:700px;margin:2rem auto;font-family:sans-serif">
      <h1>Database ready</h1>
      <p>Tables created in <code>data/portfolio.db</code>.</p>
      <p>Next steps:</p>
      <ol>
        <li>Open <a href="admin.php">admin.php</a> and log in with the password from <code>config.php</code>.</li>
        <li>Try <a href="movies-live.php">movies-live.php</a> (add rows to the <code>movie</code> table first, or run <code>seed.sql</code>).</li>
        <li>Add the form from <code>snippets/contact-form.html</code> to your <code>contact.html</code>, then test it.</li>
      </ol>
      <p><strong>Delete setup.php when done.</strong></p>
    </main></body></html>
    <?php
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Setup failed</title>';
    echo '<h1>Setup failed</h1><p>' . h($e->getMessage()) . '</p>';
}
