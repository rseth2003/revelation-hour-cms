# Backups and Recovery

A complete RHMI backup has two parts: the database and uploaded files in `storage/app/public`.

## Database backup

For MySQL or MariaDB:

```bash
mkdir -p ~/backups/rhmi
mysqldump --single-transaction --quick --lock-tables=false \
  -u rhmi_user -p rhmi | gzip > ~/backups/rhmi/rhmi-$(date +%F-%H%M).sql.gz
```

## Uploaded files

```bash
tar -czf ~/backups/rhmi/uploads-$(date +%F-%H%M).tar.gz \
  -C /var/www/rhmi storage/app/public
```

Store copies away from the server. A backup that exists only on the same VPS can disappear with the VPS.

## Suggested schedule

Take daily database backups, daily or weekly uploaded-file backups depending on activity, and a manual backup before every update. Keep several recent copies and at least one older monthly copy.

## Restore test

Backups are trustworthy only after a restore has been tested on another database or staging server.

Restore the database:

```bash
gunzip -c rhmi-backup.sql.gz | mysql -u rhmi_user -p rhmi
```

Restore uploaded files:

```bash
tar -xzf uploads-backup.tar.gz -C /var/www/rhmi
sudo chown -R www-data:www-data /var/www/rhmi/storage
```

Then run:

```bash
php artisan optimize:clear
php artisan storage:link
php artisan rhmi:check
```

## Protecting backups

Backups may include member information, prayer requests and contact details. Restrict access, encrypt off-site copies where possible and delete expired backups according to RHMI's retention policy.
