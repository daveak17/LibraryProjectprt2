# e‑Shelf Library 📚

A simple PHP + MySQL mini library system (insert/search/borrow).

## Features
- Insert books into the database
- Search & filter results (PHP + MySQL)
- Borrow books (decrements copies + records a borrow entry)

## Requirements
- PHP 7.4+ (works on PHP 8.x)
- MySQL/MariaDB
- XAMPP/MAMP/WAMP (locally) or any PHP host with MySQL

## Setup (Local with XAMPP)
1) Copy this folder to your web root, e.g.
   `C:\xampp\htdocs\LibraryProjectprt2\`
2) Start **Apache** and **MySQL** from XAMPP.
3) Open **phpMyAdmin** → **Import** → select `library_db.sql` → Run.
4) Create your DB config:
   - If `db.php` is ignored (recommended for public repos), copy `db.example.php` → `db.php` and set your credentials:
     ```php
     $DB_HOST = 'localhost';
     $DB_USER = 'root';
     $DB_PASS = '';          // set password if you use one
     $DB_NAME = 'library_db';
     ```
5) Open the app:
   - `http://localhost/LibraryProjectprt2/index.html`
   - `http://localhost/LibraryProjectprt2/search_results.php`

## Notes
- Keep only **one** search page: `search_results.php` (delete/ignore the demo `search_results.html`).
- Book detail pages use `fetch('borrow.php', { ... })`. Ensure it’s a **relative** path.
- Recommended to centralize DB connection in `db.php` and include it in PHP files with:
  ```php
  require_once __DIR__ . '/db.php';
  ```

## File map (important bits)
- `index.html` — Home page
- `insert_book.html` — Insert book form (POST → `insert_book.php`)
- `search_results.php` — Real DB search & filter
- `borrow.php` — Borrow action endpoint
- `library_db.sql` — Database schema + sample data
- `db.example.php` — Safe template for DB config (copy to `db.php` locally)

## License
MIT (or your choice).
