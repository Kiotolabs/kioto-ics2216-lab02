<?php
// movies-live.php - a DYNAMIC page. The movie list is built from the database
// every time someone visits. Edit a row in the database and this page changes
// with no HTML editing. Compare with the static movies.html from Part A.
require __DIR__ . '/config.php';
try {
    $stmt = db()->prepare('SELECT title, release_year, why_i_love_it FROM movie WHERE profile_id = :pid ORDER BY my_rank');
    $stmt->execute([':pid' => PROFILE_ID]);
    $movies = $stmt->fetchAll();
} catch (Throwable $e) {
    $movies = [];
    $dbError = $e->getMessage();
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Top 5 Movies (live from database)</title><link rel="stylesheet" href="style.css"></head><body>
<header><h1>My Top 5 Movies</h1>
<nav><a href="index.html">Home</a><a href="academic.html">Academic Journey</a><a href="hobbies.html">Hobbies</a>
<a href="movies-live.php" class="active">Top 5 Movies</a><a href="contact.html">Contact</a></nav></header>
<main><section class="card"><img src="images/movies.jpg" alt="A cinema screen and popcorn">
<h2>Straight from my database</h2>
<ol>
<?php foreach ($movies as $m): ?>
  <li><strong><?= h($m['title']) ?></strong> (<?= (int)$m['release_year'] ?>): <?= h($m['why_i_love_it']) ?></li>
<?php endforeach; ?>
</ol>
<?php if (isset($dbError)): ?><p style="color:#b00020">Could not load movies: <?= h($dbError) ?></p><?php elseif (!$movies): ?><p>No movies yet. Add rows to the <code>movie</code> table (or run <code>seed.sql</code>).</p><?php endif; ?>
</section></main></body></html>
