<?php

namespace App\Providers;

use App\Models\AboutSetting;
use App\Models\Campus;
use App\Models\CoreValue;
use App\Models\DailyWord;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\GivingMethod;
use App\Models\HeroSlide;
use App\Models\Leader;
use App\Models\LibraryCategory;
use App\Models\LibraryResource;
use App\Models\Livestream;
use App\Models\Ministry;
use App\Models\Sermon;
use App\Models\ServiceTime;
use App\Models\WebsiteSetting;
use App\Services\PublicContentCache;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        if (app()->environment('production') && config('security.force_https')) {
            URL::forceScheme('https');
        }

        $this->configureRateLimiters();
        $this->registerPublicCacheInvalidation();

        if (Schema::hasTable('website_settings')) {
            View::share('websiteSettings', PublicContentCache::remember(
                'website-settings',
                fn () => WebsiteSetting::current(),
                600
            ));
        }
    }

    private function configureRateLimiters(): void
    {
        RateLimiter::for('public-forms', function (Request $request) {
            return [
                Limit::perMinute(5)->by('ip:'.$request->ip()),
                Limit::perHour(30)->by('hour:'.$request->ip()),
            ];
        });

        RateLimiter::for('password-resets', fn (Request $request) => [
            Limit::perMinute(3)->by($request->ip()),
            Limit::perHour(10)->by('hour:'.$request->ip()),
        ]);

        RateLimiter::for('admin-writes', fn (Request $request) => [
            Limit::perMinute(90)->by((string) ($request->user()?->id ?? $request->ip())),
        ]);

        RateLimiter::for('downloads', fn (Request $request) => [
            Limit::perMinute(30)->by($request->ip()),
        ]);
    }

    private function registerPublicCacheInvalidation(): void
    {
        $models = [
            AboutSetting::class, Campus::class, CoreValue::class, DailyWord::class,
            Event::class, GalleryAlbum::class, GalleryImage::class, GivingMethod::class,
            HeroSlide::class, Leader::class, LibraryCategory::class, LibraryResource::class,
            Livestream::class, Ministry::class, Sermon::class, ServiceTime::class,
            WebsiteSetting::class,
        ];

        foreach ($models as $model) {
            $model::saved(fn () => PublicContentCache::clear());
            $model::deleted(fn () => PublicContentCache::clear());
        }
    }
}
