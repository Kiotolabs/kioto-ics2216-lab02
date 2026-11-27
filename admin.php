<?php
// admin.php - lets the portfolio owner read messages (a SELECT query).
// Simple password protection for a lab. Real sites use proper login systems.
require __DIR__ . '/config.php';
session_start();

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: admin.php');
    exit;
}

$loginError = '';
if (isset($_POST['pass'])) {
    $_SESSION['ok'] = hash_equals(ADMIN_PASS, $_POST['pass']);
    if (empty($_SESSION['ok'])) {
        $loginError = 'Incorrect password. Please try again.';
    }
}

if (empty($_SESSION['ok'])) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login</title><link rel="stylesheet" href="style.css"></head><body>
    <main style="max-width:420px;margin:2rem auto;font-family:sans-serif">
    <h1>Admin login</h1>';
    if ($loginError !== '') {
        echo '<p style="color:#b00020">' . h($loginError) . '</p>';
    }
    if (ADMIN_PASS === 'change-me-please') {
        echo '<p style="color:#b00020"><strong>Warning:</strong> you are still using the default password. Change ADMIN_PASS in config.php.</p>';
    }
    echo '<form method="post">
      <p><input type="password" name="pass" placeholder="Password" required style="padding:.5rem;width:100%"></p>
      <p><button type="submit">Login</button></p>
    </form></main></body></html>';
    exit;
}

try {
    $rows = db()->query(
      'SELECT e.enquiry_id, e.sender_name, e.sender_email, e.message, e.sent_at, p.full_name
       FROM enquiry e JOIN profile p ON p.profile_id = e.profile_id
       ORDER BY e.sent_at DESC')->fetchAll();
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Error</title><h1>Could not load messages</h1><p>' . h($e->getMessage()) . '</p>';
    exit;
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Enquiries</title><link rel="stylesheet" href="style.css"></head><body>
<header><h1>Messages sent to me</h1></header>
<main><section class="card"><p><?= count($rows) ?> message(s) <a href="admin.php?logout=1" style="float:right">Log out</a></p>
<?php if (!$rows): ?>
  <p>No messages yet. Submit the contact form to see one here.</p>
<?php else: ?>
<table><tr><th>When</th><th>From</th><th>Email</th><th>Message</th></tr>
<?php foreach ($rows as $r): ?>
<tr><td><?= h($r['sent_at']) ?></td><td><?= h($r['sender_name']) ?></td>
<td><?= h($r['sender_email']) ?></td><td><?= h($r['message']) ?></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</section></main></body></html>