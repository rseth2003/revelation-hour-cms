# Operations Guide

## Daily checks

Confirm the homepage loads, HTTPS is valid, the disk is not close to full, queue workers are running and recent backups exist.

Useful commands:

```bash
php artisan rhmi:check
php artisan queue:failed
sudo supervisorctl status
sudo systemctl status nginx php8.3-fpm mariadb redis-server
```

## Logs

Laravel logs are stored in `storage/logs`. Production should use daily rotation. Do not publish logs or paste complete production logs into public support channels because they may contain personal or technical details.

```bash
tail -f storage/logs/laravel.log
```

## Maintenance mode

```bash
php artisan down --secret="choose-a-long-temporary-secret"
```

Authorised maintainers can use the generated secret URL while other visitors see the maintenance page.

Bring the site back:

```bash
php artisan up
```

## Updating dependencies

Test updates locally or on staging before production. Review security updates regularly.

```bash
composer audit
npm audit
```

Do not use automatic force fixes blindly. Dependency changes can break the frontend or framework.

## Rollback

Before updating, record the current Git commit and create backups. If the new release fails:

```bash
git reset --hard PREVIOUS_COMMIT
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan optimize
php artisan queue:restart
```

Database migrations may need a database restore when they cannot be safely reversed.

## Changing environment settings

After editing `.env`:

```bash
php artisan optimize:clear
php artisan optimize
php artisan queue:restart
```

## Email

Use a real SMTP provider in production. Test password reset and contact-related mail before launch. Configure SPF, DKIM and DMARC through the email provider and domain DNS panel.
