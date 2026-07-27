<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\Cache;
use Throwable;

class PublicContentCache
{
    private const VERSION_KEY = 'rhmi:public-content:version';

    public static function remember(string $key, Closure $callback, ?int $seconds = null): mixed
    {
        $seconds ??= (int) config('cache.public_ttl', 300);

        try {
            $version = (int) Cache::get(self::VERSION_KEY, 1);
            $cacheKey = "rhmi:public:v{$version}:{$key}";
            $cached = Cache::get($cacheKey);

            if ($cached !== null && self::isSafeValue($cached)) {
                return $cached;
            }

            // Remove values serialized by an older application version or values
            // containing Eloquent models/collections. Persisting those objects can
            // produce __PHP_Incomplete_Class after deployments or autoload changes.
            Cache::forget($cacheKey);

            $value = $callback();

            // Only persist deployment-safe primitive data. Eloquent models and
            // collections are returned normally but deliberately not serialized.
            if (self::isSafeValue($value)) {
                Cache::put($cacheKey, $value, $seconds);
            }

            return $value;
        } catch (Throwable) {
            return $callback();
        }
    }

    public static function clear(): void
    {
        try {
            $version = (int) Cache::get(self::VERSION_KEY, 1);
            Cache::forever(self::VERSION_KEY, $version + 1);
        } catch (Throwable) {
            // Content updates must still succeed if the cache server is down.
        }
    }

    private static function isSafeValue(mixed $value): bool
    {
        if ($value === null || is_scalar($value)) {
            return true;
        }

        if (! is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if (! self::isSafeValue($item)) {
                return false;
            }
        }

        return true;
    }
}
