<?php
// submit.php - receives the contact form and stores it in the enquiry table.
// Journey: browser (client) POSTs form data -> this script (server) validates
// it -> INSERT into the database -> redirect to a thank-you page.
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {   // only accept form submissions
    http_response_code(405);
    exit('Please use the contact form.');
}

// 1. Anti-spam "honeypot": a hidden field humans never fill in.
if (!empty($_POST['website'])) { header('Location: thanks.html'); exit; }

// 2. Read and tidy the input (names match the form's name="..." attributes).
$name    = trim($_POST['sender_name']  ?? '');
$email   = trim($_POST['sender_email'] ?? '');
$message = trim($_POST['message']      ?? '');

// 3. Server-side validation (browser checks can be bypassed).
$errors = [];
if ($name === '' || mb_strlen($name) > 80)                     $errors[] = 'Please enter your name (max 80 characters).';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))                $errors[] = 'Please enter a valid email address.';
if ($message === '' || mb_strlen($message) > 1000)             $errors[] = 'Message must be 1 to 1000 characters.';

if ($errors) {
    http_response_code(422);
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Oops</title><h1>Oops!</h1><ul>';
    foreach ($errors as $e) echo '<li>' . h($e) . '</li>';
    echo '</ul><p><a href="contact.html">Go back</a></p>';
    exit;
}

// 4. Store it. A PREPARED STATEMENT keeps user input separate from the SQL,
//    which blocks SQL injection attacks.
try {
    $stmt = db()->prepare(
        'INSERT INTO enquiry (profile_id, sender_name, sender_email, message)
         VALUES (:pid, :name, :email, :msg)'
    );
    $stmt->execute([':pid' => PROFILE_ID, ':name' => $name, ':email' => $email, ':msg' => $message]);
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Server error</title>';
    echo '<h1>Sorry, your message could not be saved.</h1>';
    echo '<p>Please try again later. (' . h($e->getMessage()) . ')</p>';
    echo '<p><a href="contact.html">Go back</a></p>';
    exit;
}

// 5. Reply to the browser.
header('Location: thanks.html', true, 303);
exit;
