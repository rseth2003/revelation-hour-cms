# Production Readiness Build

This build adds the final operations layer without changing the main RHMI feature set.

## Included

* Security headers and optional production HTTPS enforcement
* HSTS support for confirmed HTTPS deployments
* Named limits for public forms, password reset requests and downloads
* Expiring signed links for event-registration confirmation pages
* Request-size protection aligned with the existing large video limit
* Portable public-content caching with automatic invalidation
* Database defaults with optional Redis support
* A production environment template
* A custom `php artisan rhmi:check` command
* Privacy, Terms and Cookie pages linked in the footer
* Nginx, Apache and Supervisor examples
* Human-written deployment, security, caching, backup and operations guides
* A project-specific GitHub README and system overview

## Important deployment note

Do not enable `SECURITY_HSTS=true` until the final domain is working correctly over HTTPS. HSTS is intentionally controlled through the environment file.
