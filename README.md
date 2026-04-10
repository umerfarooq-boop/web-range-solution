# laravel-tasks

A Laravel 13 project built as part of a backend assessment. It covers four things — a REST API for products, consuming an external API, web scraping, and sending HTTP requests with custom headers.

---

## What's inside

- **Task 1** — Product REST API (Create, List, Delete) with validation and pagination
- **Task 2** — Fetches posts from JSONPlaceholder, shows only title and body, supports search
- **Task 3** — Scrapes quotes and author names from quotes.toscrape.com, supports multiple pages
- **Task 4** — Sends an HTTP request with custom headers and retry logic on failure

---

## Requirements

- PHP 8.2+
- Composer
- MySQL or SQLite

---

## Setup

Clone the repo and install dependencies:

```bash
git clone https://github.com/your-username/laravel-tasks.git
cd laravel-tasks
composer install
```

Copy the env file and generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

Set your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webrange
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

Enable API routes (Laravel 11+):

```bash
php artisan install:api
```

Start the server:

```bash
php artisan serve
```

---

## API Endpoints

### Products (Task 1)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | List all products |
| GET | `/api/products?per_page=5` | List with pagination |
| POST | `/api/products` | Create a product |
| DELETE | `/api/products/{id}` | Delete a product |

POST body example:
```json
{
  "name": "Laptop",
  "price": 999.99,
  "description": "A powerful laptop"
}
```

### External Posts (Task 2)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/posts` | Fetch first 10 posts |
| GET | `/api/posts?search=keyword` | Filter posts by title |

### Web Scraping (Task 3)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/scrape` | Scrape quotes from page 1 |
| GET | `/api/scrape?pages=3` | Scrape multiple pages |

### HTTP Demo (Task 4)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/http-demo` | Request with custom headers + retry logic |

---

## Notes

- No extra packages were installed — everything uses Laravel's built-in HTTP client and PHP's DOMDocument for scraping
- Controllers are in `app/Http/Controllers/Api/`
- Routes are defined in `routes/api.php`
