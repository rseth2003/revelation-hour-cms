# Security Guide

Security is a continuing operating practice, not a one-time setting.

## Production settings

Use these values in production:

```env
APP_ENV=production
APP_DEBUG=false
FORCE_HTTPS=true
SECURITY_HSTS=true
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
LOG_LEVEL=warning
```

Never expose `.env`, Git metadata, backups or database exports through the web server.

## Rate limiting

The application has named limits for public forms, password reset requests, downloads and administrative activity. Login attempts are also throttled by email and IP address.

A reverse proxy or CDN can add another layer for abusive traffic. Application rate limits should remain enabled even when a CDN is used.

## Accounts and roles

Use unique staff accounts. Do not share one administrator password among several people. Remove access promptly when a role changes. Give media, ushering and pastoral teams only the permissions needed for their work.

Use long passwords and enable multi-factor authentication at the hosting, email, domain and GitHub account level. The current application does not yet provide built-in two-factor authentication for CMS accounts.

## Uploads

Controllers validate image, video and PDF types and size limits. Keep PHP and web server limits aligned with the application. Uploaded executable files must never be accepted.

Review media before publishing. PDFs can contain links and active content when opened in a reader, so only trusted administrators should upload library documents.

## Browser headers

The `SecurityHeaders` middleware adds MIME sniffing protection, framing protection, referrer controls, a permissions policy, HSTS on HTTPS and a content security policy.

The current CSP allows inline scripts and styles because the existing frontend uses them. A future refactor can remove inline code and tighten the policy further. Test third-party video and meeting embeds after every CSP change.

## Privacy and records

Collect only information that RHMI genuinely needs. Record communication consent separately from attendance or membership status. Limit prayer-request access because it may contain sensitive personal information.

The public Privacy, Terms and Cookie pages are working drafts. RHMI should review them against its actual practices and local legal advice before launch.

Create a retention routine for old event registrations, inactive accounts, communication logs and prayer requests. Backups also contain personal information and require the same protection as the live database.

## Server protection

On a VPS:

* Allow only SSH, HTTP and HTTPS through the firewall.
* Use SSH keys and disable password login after confirming key access.
* Keep Ubuntu, PHP, Nginx, MariaDB and Redis updated.
* Install Fail2ban where appropriate.
* Run the web application as an unprivileged user.
* Keep database and Redis ports bound to localhost unless private networking is intentionally configured.
* Monitor disk space, failed logins, queue failures and certificate expiry.

## Incident response

If an account or server may be compromised:

1. Put the site in maintenance mode if needed.
2. Preserve logs and note the time of the incident.
3. Revoke exposed credentials and sessions.
4. Rotate the application, database, SMTP, hosting and API secrets that may have been accessed.
5. Patch the cause before restoring service.
6. Restore from a verified clean backup when necessary.
7. Follow applicable notification duties with professional advice.
