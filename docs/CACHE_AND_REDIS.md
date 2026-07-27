# Cache and Redis

## What Redis does

Redis keeps frequently used data in memory. In this project it can support cache, sessions and queues. It does not replace MySQL or MariaDB, which remains the permanent source of website and member records.

## Default portable setup

The production example uses database-backed cache, sessions and queues. This works on most Laravel hosts and does not require Redis.

```env
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

Make sure the cache, sessions and jobs migrations have been run.

## VPS setup with Redis

Install Redis and the PHP extension:

```bash
sudo apt install redis-server php8.3-redis
sudo systemctl enable --now redis-server
redis-cli ping
```

The expected reply is `PONG`.

Update `.env`:

```env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null
```

Then run:

```bash
php artisan optimize:clear
php artisan optimize
php artisan queue:restart
```

Do not expose port 6379 publicly.

## Public content cache

Homepage and selected public lists use short-lived cache entries. When public content changes, the application increments a cache generation number. New visitors immediately use fresh keys, while old entries expire naturally.

The default public cache lifetime is five minutes:

```env
PUBLIC_CACHE_TTL=300
```

This can be increased for a mostly static site. Do not set it very high unless content editors understand the delay and cache invalidation has been tested.

## Laravel optimization commands

Use these after production deployment:

```bash
php artisan optimize
```

During debugging or after changing environment values:

```bash
php artisan optimize:clear
```

Do not run `config:cache` while `.env` is incomplete.
