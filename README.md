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

---

## 🏗️ Architecture

This is a **core PHP project** that manually bootstraps selected Laravel/Illuminate packages — no Artisan, no `public/index.php` kernel, no service providers auto-discovery.

```
bootstrap/app.php          ← Application entry point (wires everything together)
├── Container + Events     ← Illuminate IoC container & event dispatcher
├── Router                 ← Illuminate routing with middleware support
├── Eloquent (Capsule)     ← Database ORM via DB Capsule Manager
├── Blade Engine           ← Blade templating with compiled view cache
└── Request → Dispatch → Response
```

### Directory Structure

```
gauri-mobile/
├── App/
│   ├── Core/
│   │   ├── Request.php         # Custom request helpers
│   │   └── Session.php         # Session management
│   ├── Http/
│   │   ├── Controllers/        # All route controllers
│   │   │   ├── AuthController.php
│   │   │   ├── BackupController.php
│   │   │   ├── DatatableController.php
│   │   │   ├── HomeController.php
│   │   │   ├── InvoiceController.php
│   │   │   ├── ProductController.php
│   │   │   ├── SalesController.php
│   │   │   └── SettingController.php
│   │   ├── Middleware/
│   │   │   └── AuthMiddleware.php
│   │   └── Kernel.php          # Middleware registration
│   ├── Model/
│   │   └── QueryBuilder.php    # Custom Eloquent query helpers
│   └── Services/
│       ├── DatabaseBackup.php  # SQL dump & backup management
│       ├── MailService.php     # PHPMailer SMTP wrapper
│       └── PdfService.php      # DomPDF wrapper
├── bootstrap/
│   └── app.php                 # Application bootstrap & entry point
├── config/
│   ├── app.php                 # App-level config
│   └── database.php            # MySQL connection config
├── helpers/
│   └── methods.php             # Global helper functions (autoloaded)
├── migrations/                 # SQL schema files
│   ├── users.sql
│   ├── roles.sql
│   ├── user_roles.sql
│   ├── products.sql
│   ├── sales.sql
│   ├── invoices.sql
│   ├── invoice_items.sql
│   └── settings.sql
├── public/
│   ├── index.php               # Web root entry point
│   ├── assets/                 # CSS, JS, images
│   └── uploads/                # User-uploaded files
├── routes/
│   └── web.php                 # All application routes
├── storage/
│   ├── cache/                  # Blade compiled views
│   ├── backups/                # SQL backup files
│   └── logs/                   # Application logs
├── views/                      # Blade templates
├── vendor/                     # Composer dependencies (git-ignored)
├── composer.json
└── .htaccess                   # URL rewriting rules
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

### 3. Configure the Database

Edit `config/database.php` with your MySQL credentials:

```php
return [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'database' => 'gauri_mobiles',
    'username' => 'your_db_user',
    'password' => 'your_db_password',
    'charset'  => 'utf8mb4',
    'collation'=> 'utf8mb4_unicode_ci',
    'prefix'   => '',
];
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

**Apache** — ensure `mod_rewrite` is enabled and the `.htaccess` in the project root handles rewrites to `bootstrap/app.php`, while `public/.htaccess` handles static assets.

**PHP built-in server (dev only):**

```bash
php -S localhost:8000 -t public
```

Then open [http://localhost:8000](http://localhost:8000).

---

## 📬 Email Configuration

Mail is sent via Gmail SMTP using PHPMailer. Update credentials in `App/Services/MailService.php`:

```php
$this->mail->Username = 'your-email@gmail.com';
$this->mail->Password = 'your-app-password'; // Gmail App Password, not your login password
$this->mail->setFrom('your-email@gmail.com', 'Gauri Mobiles');
```

> **Note:** Use a [Gmail App Password](https://support.google.com/accounts/answer/185833), not your regular Gmail password.

---

## 🔒 Security Notes

- Passwords are hashed (do **not** store plain text passwords).
- The `auth` middleware protects all `/admin/*` routes.
- Keep `config/database.php` and `MailService.php` credentials out of version control — use a `.env` file or environment variables in production.

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
