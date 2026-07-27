# Deployment Guide

This guide covers the most common ways to run RHMI CMS. Production hosting should always serve the `public` directory, use HTTPS and keep `.env` outside version control.

## Before deployment

Prepare these items first:

1. A domain or subdomain
2. A MySQL or MariaDB database
3. PHP 8.3+ with common Laravel extensions
4. Composer 2
5. Node.js 20+ for building assets
6. SMTP details for password resets and website email
7. A backup destination

Copy `.env.production.example` to `.env`, replace every placeholder and generate the application key:

```bash
cp .env.production.example .env
php artisan key:generate
```

Do not reuse a key from another Laravel project.

## Ubuntu VPS with Nginx

Install the main packages:

```bash
sudo apt update
sudo apt install -y nginx mariadb-server redis-server supervisor unzip git curl
sudo apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-xml php8.3-curl php8.3-mbstring php8.3-zip php8.3-gd php8.3-bcmath php8.3-intl php8.3-redis
```

Install Composer and Node.js from trusted official sources. Clone the repository into `/var/www/rhmi`:

```bash
sudo mkdir -p /var/www/rhmi
sudo chown -R "$USER":www-data /var/www/rhmi
git clone -b cms-dashboard YOUR_REPOSITORY_URL /var/www/rhmi
cd /var/www/rhmi
```

Install and build:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
cp .env.production.example .env
php artisan key:generate
```

Create the database:

```sql
CREATE DATABASE rhmi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'rhmi_user'@'localhost' IDENTIFIED BY 'use-a-long-random-password';
GRANT ALL PRIVILEGES ON rhmi.* TO 'rhmi_user'@'localhost';
FLUSH PRIVILEGES;
```

Update `.env`, then finish setup:

```bash
php artisan migrate --force
php artisan storage:link
php artisan optimize
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

Copy `deploy/nginx/rhmi.conf` to `/etc/nginx/sites-available/rhmi`, update the domain and PHP socket, then enable it:

```bash
sudo ln -s /etc/nginx/sites-available/rhmi /etc/nginx/sites-enabled/rhmi
sudo nginx -t
sudo systemctl reload nginx
```

Install SSL after DNS points to the server:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d example.org -d www.example.org
```

Set `FORCE_HTTPS=true`, `SECURITY_HSTS=true`, `SESSION_SECURE_COOKIE=true` and the final `APP_URL`, then run:

```bash
php artisan optimize
php artisan rhmi:check
```

## Queue worker and scheduler

Copy the Supervisor example from `deploy/supervisor/rhmi-worker.conf`, update paths and enable it:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl status
```

Add Laravel's scheduler to the `www-data` crontab:

```bash
sudo crontab -u www-data -e
```

Add:

```cron
* * * * * cd /var/www/rhmi && php artisan schedule:run >> /dev/null 2>&1
```

## Apache or cPanel

The preferred document root is `PROJECT/public`. On cPanel, create the domain or subdomain with its document root set to the project's `public` directory.

When the hosting panel does not allow that layout, keep the Laravel project outside `public_html`, copy only the contents of Laravel's `public` directory into `public_html`, and carefully update `index.php` paths. This fallback is less clean and should only be used when the host gives no better option.

Enable Apache modules where you control the server:

```bash
sudo a2enmod rewrite headers ssl
sudo systemctl restart apache2
```

Use `deploy/apache/rhmi.conf` as the virtual-host starting point.

On shared hosting without SSH:

1. Build assets locally with `npm run build`.
2. Upload the project without `node_modules`.
3. Install Composer dependencies through the host's terminal or upload a locally built `vendor` directory created on a compatible PHP platform.
4. Create the database and update `.env`.
5. Run migrations from the terminal. If no terminal is available, choose hosting that provides one. Web-based migration scripts are unsafe.
6. Create the storage link through the terminal. If symbolic links are blocked, ask the host to enable them.

## Hostinger

For Hostinger shared or cloud hosting, confirm the plan supports PHP 8.3, SSH, Composer, cron jobs, custom document roots and enough upload size for media. Redis availability depends on the product tier.

For Hostinger VPS, follow the Ubuntu VPS steps. Their control panel can manage DNS and the server, but the Laravel deployment principles stay the same.

## Windows local setup

Laragon is usually simpler for Laravel than manually combining WAMP or XAMPP.

### Laragon

1. Install Laragon with PHP 8.3+.
2. Put the project in `C:\laragon\www\revelation-hour-cms`.
3. Open Laragon Terminal.
4. Run:

```powershell
copy .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan storage:link
php artisan serve
```

### XAMPP or WAMP

Use their PHP and MySQL services, but run Laravel through `php artisan serve` during local development. Do not browse the project folder directly through Apache unless you have configured a virtual host whose document root points to `public`.

Create a MySQL database, change `.env` to use MySQL and run migrations.

## macOS local setup

Install PHP, Composer, Node.js and a database through Homebrew or use Laravel Herd. From the project directory:

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan storage:link
php artisan serve
```

## Generic production update

```bash
cd /path/to/project
php artisan down --render="errors::503"
git pull origin cms-dashboard
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan optimize
php artisan queue:restart
php artisan rhmi:check
php artisan up
```

Back up the database and uploaded files before every production update.
