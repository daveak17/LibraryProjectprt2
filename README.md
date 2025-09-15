# e-Shelf Library 📚

A simple **PHP + MySQL** mini library system to insert, search/filter, and borrow books.

---

## Features
- Insert books into the database
- Search & filter by title/category/year
- Borrow books (decrements copies and logs a borrow entry)
- Book pages fetch **live available copies** on load via `book_info.php`

## Tech stack
- PHP 7.4+ (works on 8.x)
- MySQL / MariaDB
- Bootstrap 4
- (Local dev) XAMPP/MAMP/WAMP

---

## Quick start (Local with XAMPP)

1. **Copy the project** to your web root, e.g.  
   `C:\xampp\htdocs\LibraryProjectprt2\`

2. **Start** Apache and MySQL from XAMPP.

3. **Create the database**  
   - Open **phpMyAdmin** → **Import** → select `library_db.sql` → **Go**.

4. **DB config (local only)**  
   - `db.php` is **ignored** in this public repo.  
   - Copy `db.example.php` → **`db.php`** and set your local credentials:
     ```php
     $DB_HOST = 'localhost';
     $DB_USER = 'root';
     $DB_PASS = '';         // set a password if you use one
     $DB_NAME = 'library_db';
     ```

5. **Run it**  
   - Home: `http://localhost/LibraryProjectprt2/index.html`  
   - Search: `http://localhost/LibraryProjectprt2/search_results.php`

> Tip: keep only one search page: **`search_results.php`** (the real DB page).  
> If you see a `search_results.html` demo, remove it.

---

## Endpoints (PHP)
- `search_results.php` — search & filter UI (queries `book` table)  
- `borrow.php` — POST `book_title` → decrements copies + inserts into `borrow`  
- `book_info.php` — GET `book_title` (or `book_id`) → returns JSON with live `copies`  
- `insert_book.php` — handles inserts from `insert_book.html`

All DB-using files include the central connection:
```php
require_once __DIR__ . '/db.php';
