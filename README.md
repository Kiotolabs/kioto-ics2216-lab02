# Portfolio Starter Backend (ICS 2216 Lab 2, Part B, Section 17)

PHP + SQLite. No MySQL needed. This folder is the **instructor-provided backend**
for the contact form journey in Part B, Section 17.

## Files

| File | Job |
|---|---|
| config.php | Settings (DB path, profile id, admin password) and the DB connection |
| setup.php | Creates the tables (run once, then delete) |
| seed.sql | Optional sample data for testing movies-live.php and the SQL queries |
| submit.php | Receives the contact form and INSERTs into `enquiry` |
| thanks.html | Confirmation page |
| admin.php | Password-protected page that SELECTs and shows messages |
| movies-live.php | Dynamic Top 5 Movies page built from the `movie` table |
| snippets/contact-form.html | The form markup to paste into your contact.html |
| data/ | Holds portfolio.db (blocked from public download) |
| router.php | Optional router for PHP's built-in server (protects data/) |

## Run it (choose one)

### Option A - Laragon / XAMPP (Apache, recommended)

Apache honours `data/.htaccess`, so the database cannot be downloaded.

1. Start Apache.
2. Copy your whole `my-portfolio` folder into `C:\laragon\www\` (or `C:\xampp\htdocs\`).
3. Copy ALL files from this starter into that same folder (so `contact.html` and `submit.php` sit together).
4. EITHER copy your own `portfolio.db` into `data/`, OR visit `http://localhost/my-portfolio/setup.php` to create a fresh one.
5. In `contact.html` set the form tag to: `<form action="submit.php" method="post">` (or paste `snippets/contact-form.html`).
6. Add the hidden spam trap inside the form (already in the snippet).
7. Change `ADMIN_PASS` in `config.php`.
8. Open `http://localhost/my-portfolio/contact.html`, send a test message.
9. Check it in `http://localhost/my-portfolio/admin.php` or in DB Browser for SQLite.
10. Delete `setup.php` when done.

### Option B - PHP's built-in server (no Apache)

In a terminal inside this folder:

    php -S localhost:8000 router.php

then open `http://localhost:8000/...`. The router blocks downloads of `data/*.db`.
Without the router (`php -S localhost:8000`) the site still runs, but the database
file is downloadable - use only for local testing.

## Test the full journey (Section 17)

1. `http://localhost:8000/setup.php` - creates the tables.
2. (Optional) load `seed.sql` in DB Browser to add sample movies/skills/hobbies.
3. `http://localhost:8000/movies-live.php` - should list your movies from the DB.
4. Paste `snippets/contact-form.html` into your `contact.html`, submit a message.
5. `http://localhost:8000/admin.php` - log in, read the message.

## Important

- GitHub Pages and Google Sites CANNOT run PHP. Your public site stays static; this
  backend runs locally in the lab or on the instructor's PHP server.
- Change `ADMIN_PASS` in `config.php`. The default password is intentionally weak
  and triggers a warning on the login page.
- Delete `setup.php` after use. Do not ship it with your public site.
- `PROFILE_ID` in `config.php` must match the `profile_id` of your row in the
  `profile` table (usually 1).