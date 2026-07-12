# Gauri Mobiles — Admin Panel

A lightweight, custom-built **PHP 8 admin panel** for managing a mobile shop's products, sales, and invoices. Built without a full framework — it uses hand-picked **Illuminate (Laravel) components** wired together manually, giving you the power of Eloquent ORM, Blade templating, and Laravel routing in a lean, dependency-minimal setup.

---

## ✨ Features

- 🔐 **Authentication** — Session-based login/register with middleware protection
- 📦 **Product Management** — Add, edit, and track product inventory
- 🧾 **Invoice Management** — Create, view, edit, and email invoices as PDF attachments
- 💰 **Sales Tracking** — Record sales with auto-calculated profit (sell price − cost − handling charges)
- ⚙️ **Settings** — Configurable shop-level settings
- 🗄️ **Database Backups** — Create, download, email, and delete SQL backups
- 📊 **Datatable API** — Server-side datatable endpoint for dynamic data grids
- 📄 **PDF Generation** — Invoice PDFs generated via DomPDF
- 📧 **Email Service** — Send invoices and backups via Gmail SMTP (PHPMailer)
- 🌍 **Environment Management** — Native `.env` file parsing for secure configurations (zero dependencies)

---

## 🏗️ Architecture

This is a **core PHP project** that manually bootstraps selected Laravel/Illuminate packages using a modern MVC lifecycle pattern. 

```
public/index.php           ← Web root entry point (Receives Request, Sends Response)
├── bootstrap/app.php      ← Bootstraps the application and returns $app container
│   ├── App\Core\Environment      ← Parses .env variables
│   ├── App\Core\Application      ← IoC Container, Facades, Event Dispatcher, Router
│   ├── App\Database\DatabaseManager ← Bootstraps Eloquent Capsule
│   └── App\Core\ViewManager      ← Configures Blade compiler and view factory
└── routes/web.php         ← Maps URLs to Controllers
```

### Directory Structure

```
gauri-mobile/
├── app/
│   ├── Helpers/
│   │   └── functions.php       # Global helper functions (env, view, asset, etc.)
│   └── Exceptions/             # Application exceptions
├── App/
│   ├── Core/                   # Core application managers (Container, View, Env)
│   ├── Database/               # Database management and QueryBuilder
│   ├── Http/
│   │   ├── Controllers/        # All route controllers
│   │   ├── Middleware/         # Route middleware 
│   │   └── Kernel.php          # Middleware registration
│   └── Services/               # Domain logic (Email, Backups, PDF)
├── bootstrap/
│   └── app.php                 # Application bootstrap (returns $app)
├── config/
│   ├── app.php                 # App-level config
│   └── database.php            # MySQL connection config (reads from .env)
├── migrations/                 # SQL schema files
├── public/
│   ├── index.php               # Web root entry point (Request/Response lifecycle)
│   ├── assets/                 # CSS, JS, images
│   └── uploads/                # User-uploaded files
├── resources/
│   └── views/                  # Blade templates
├── routes/
│   └── web.php                 # All application routes
├── storage/
│   ├── backups/                # SQL backup files
│   ├── framework/              # Blade compiled views and sessions
│   └── logs/                   # Application logs
├── vendor/                     # Composer dependencies (git-ignored)
├── .env.example                # Environment variables template
└── composer.json
```

---

## 🗄️ Database Schema

| Table          | Description                                        |
|----------------|----------------------------------------------------|
| `users`        | Admin accounts (name, email, hashed password)      |
| `roles`        | Role definitions                                   |
| `user_roles`   | Many-to-many user ↔ role assignments               |
| `products`     | Product catalogue with stock tracking              |
| `sales`        | Sales records with auto-computed profit column     |
| `invoices`     | Customer invoices (billing, totals, payment method)|
| `invoice_items`| Line items for each invoice                        |
| `settings`     | Key-value shop settings                            |

---

## ⚙️ Requirements

| Requirement | Version  |
|-------------|----------|
| PHP         | `^8.0`   |
| MySQL       | `5.7+` / `8.0+` |
| Composer    | `2.x`    |
| Web Server  | Apache (with `mod_rewrite`) or Nginx |

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <your-repo-url> gauri-mobile
cd gauri-mobile
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure the Environment

Copy the `.env.example` file to `.env` and configure your settings:

```bash
cp .env.example .env
```

Update your `.env` with MySQL credentials, SMTP settings, and mysqldump paths:
```env
DB_DATABASE=gauri_mobiles
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM=your-email@gmail.com
```

### 4. Create the Database & Run Migrations

```bash
# Create the database
mysql -u root -p -e "CREATE DATABASE gauri_mobiles CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run each migration
mysql -u root -p gauri_mobiles < migrations/users.sql
mysql -u root -p gauri_mobiles < migrations/roles.sql
mysql -u root -p gauri_mobiles < migrations/user_roles.sql
mysql -u root -p gauri_mobiles < migrations/products.sql
mysql -u root -p gauri_mobiles < migrations/sales.sql
mysql -u root -p gauri_mobiles < migrations/invoices.sql
mysql -u root -p gauri_mobiles < migrations/invoice_items.sql
mysql -u root -p gauri_mobiles < migrations/settings.sql
```

### 5. Set Storage Permissions

```bash
chmod -R 775 storage/
```

### 6. Configure the Web Server

Point your virtual host document root to the `public/` directory.

**PHP built-in server (dev only):**
```bash
php -S localhost:8000 -t public
```
Then open [http://localhost:8000](http://localhost:8000).

---

## 📬 Email Configuration

Mail is sent via Gmail SMTP using PHPMailer. Ensure you have populated the `MAIL_*` keys in your `.env` file. 

> **Note:** Use a [Gmail App Password](https://support.google.com/accounts/answer/185833), not your regular Gmail password.

---

## 🔒 Security Notes

- Passwords are hashed (do **not** store plain text passwords).
- The `auth` middleware protects all `/admin/*` routes.
- The `.env` file keeps sensitive credentials out of version control. The `.gitignore` file ensures `.env` is never committed.

---

## 📦 Key Dependencies

| Package                    | Purpose                          |
|----------------------------|----------------------------------|
| `illuminate/routing`       | Laravel-style routing            |
| `illuminate/database`      | Eloquent ORM & Query Builder     |
| `illuminate/view`          | Blade templating engine          |
| `illuminate/container`     | IoC/DI container                 |
| `illuminate/http`          | HTTP Request/Response            |
| `illuminate/support`       | Facades, collections, helpers    |
| `dompdf/dompdf`            | PDF generation for invoices      |
| `phpmailer/phpmailer`      | SMTP email delivery              |

---

## 📄 License

Private project — © Gauri Mobiles. All rights reserved.
