# RHMI System Overview

## Purpose

RHMI CMS combines a public church website with a private administration area. Visitors can read public content and submit selected forms without an account. Authorised staff sign in to manage content and records.

## Main application areas

Public content is stored in Eloquent models and displayed through Blade views. Administration controllers validate input before writing to the database. Uploaded media is stored on the public disk and exposed through Laravel's storage link.

The main modules are website settings, hero slides, campuses, ministries, sermons, daily words, events, registrations, gallery, prayer requests, members, attendance, communication, eLibrary, leadership, service times, livestreams and giving methods.

## Access control

Routes under `/admin` require authentication. Selected modules also use the `role` middleware. Roles should follow least privilege: each person should receive only the access needed for their work.

## Public forms

Prayer requests and event registrations use validation and named rate limiters. Registration success links are signed and expire after thirty minutes. Public forms should never be used to collect information that the ministry does not genuinely need.

## Cache design

Public content uses short-lived caching. A generation key changes whenever a public-content model is saved or deleted. This makes old keys harmless without relying on Redis cache tags, so the same design works with file, database and Redis stores.

If the cache service fails, public content falls back to a direct database query rather than blocking an update or taking the website offline.

## Sessions and queues

Database drivers are the portable default. Redis is recommended on a managed VPS because it is faster for cache, sessions and queues. Redis is not the source of truth; MySQL or MariaDB remains the permanent database.

## Scheduled work

Laravel's scheduler should run every minute in production. Queue workers should be supervised so they restart after a crash or server reboot.

## Security layers

The application uses Laravel authentication, CSRF protection, validation, role middleware, rate limiting, signed URLs, secure cookie settings and browser security headers. HTTPS must be enabled in production.

File validation is enforced in controllers. Web server upload limits must be kept in line with the Laravel limits, especially because hero videos can be large.

## Update workflow

Create a database and file backup. Enable maintenance mode. Pull the approved branch. Install production dependencies. Run migrations. Build assets when required. Clear and rebuild Laravel caches. Restart queue workers. Run the health check. Disable maintenance mode.

## Important folders

`app/Http/Controllers` contains request handling and validation.

`app/Models` contains database models.

`resources/views` contains public and admin Blade templates.

`routes` contains public, authentication and module routes.

`database/migrations` contains the database history.

`storage/app/public` contains uploaded public media.

`docs` contains deployment and operations guidance.

`deploy` contains example server configuration files.
