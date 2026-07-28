# Revelation Hour Ministries International CMS

This repository contains the public website and content management system for Revelation Hour Ministries International. It was built as a practical Laravel application for managing church content, people, events and communication from one place.

## What the system includes

The public website includes the homepage, About pages, leadership, ministries, campuses, service times, events, event registration, sermons, Word of the Day, gallery, livestreams, eLibrary, giving information, contact and prayer requests.

The administration area includes user roles, member records, attendance, event registrations, communication tools, website settings, analytics, media management, livestream management, library resources and giving methods.

The system also includes:

* Role-based administration
* CSRF protection and escaped Blade output
* Login and form rate limiting
* Secure response headers
* Optional HTTPS enforcement and HSTS
* Validated file uploads
* Signed event-registration confirmation links
* Cache invalidation when public content changes
* Database or Redis cache, session and queue support
* PWA installation assets
* Deployment and maintenance documentation

## Technical requirements

* PHP 8.3 or newer
* Composer 2
* Node.js 20 or newer
* MySQL 8, MariaDB 10.6+, PostgreSQL or SQLite
* Nginx or Apache for production

Redis is optional. The website works with database-backed cache, sessions and queues when Redis is unavailable.

## Quick local setup

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

For active development, use:

```bash
composer run dev
```

## First production deployment

Read [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) before publishing the website. The basic production sequence is:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize
php artisan rhmi:check
```

The web server document root must point to the project's `public` directory. Never point a domain at the project root.

## Documentation

* [Deployment guide](docs/DEPLOYMENT.md)
* [Security guide](docs/SECURITY.md)
* [Caching and Redis](docs/CACHE_AND_REDIS.md)
* [Backups and recovery](docs/BACKUPS.md)
* [Operations and updates](docs/OPERATIONS.md)
* [System overview](SYSTEM.md)

## Safe repository rules

Do not commit `.env`, database dumps, private keys, uploaded member records or production backups. The included `.env.production.example` contains placeholders only.

## Branch workflow

The active project branch is `cms-dashboard`.

```bash
git checkout cms-dashboard
git pull origin cms-dashboard
```

After testing a change:

```bash
git add .
git commit -m "Describe the completed change"
git push origin cms-dashboard
```

## Legal and privacy note

The project contains practical Privacy, Terms and Cookie pages, but they are starting documents rather than legal advice. Before launch, RHMI should confirm that the wording matches its real data collection, communication, donation and record-retention practices.

## Project ownership

Built for Revelation Hour Ministries International.

## CMS roles and module access

The Super Admin controls both a user's role and the CMS modules that user may open. During account creation or editing, the Super Admin can select all modules or choose only the required areas. For example, a Senior Usher can be limited to Members and Attendance. Permissions are checked on the server, not only hidden in the sidebar.

## Security headers during development

Security headers remain enabled because they protect the production website. The local policy separately allows the Vite development server on localhost, so `composer run dev` can load CSS and JavaScript normally. Production keeps the stricter policy.


## Praise Reports

The public Community menu includes a Praise Reports page for testimonies. Approved reports can include a person's photo, written testimony, scripture, audio, uploaded video or a YouTube link. Selected reports can appear on the homepage. Public encouragements are held for CMS moderation before publication.
