<?php

use App\Http\Controllers\Admin\BibleLookupController;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\DailyWordController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\MinistryController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PrayerRequestController as AdminPrayerRequestController;
use App\Http\Controllers\Admin\SermonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PrayerRequestController;
use App\Models\Campus;
use App\Models\DailyWord;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\Ministry;
use App\Models\Sermon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ministries = Ministry::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->limit(6)
        ->get();

    $events = Event::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('event_date')
        ->limit(12)
        ->get();

    $featuredSermon = Sermon::query()
        ->where('is_published', true)
        ->where('is_featured', true)
        ->first()
        ?? Sermon::query()
            ->where('is_published', true)
            ->orderByDesc('sermon_date')
            ->first();

    $featuredDailyWord = \App\Models\DailyWord::query()
        ->where('is_published', true)
        ->whereDate('publish_date', '<=', now()->toDateString())
        ->where('is_featured', true)
        ->first()
        ?? \App\Models\DailyWord::query()
            ->where('is_published', true)
            ->whereDate('publish_date', '<=', now()->toDateString())
            ->orderByDesc('publish_date')
            ->first();

    return view('home', compact('events', 'ministries', 'featuredSermon', 'featuredDailyWord'));
})->name('home');

Route::view('/about', 'pages.about')->name('about');


Route::get('/campuses', function () {
    $campuses = Campus::query()
        ->where('is_published', true)
        ->orderByDesc('is_main_campus')
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    return view('pages.campuses', compact('campuses'));
})->name('campuses');

Route::get('/campuses/{campus:slug}', function (Campus $campus) {
    abort_unless($campus->is_published, 404);

    return view('pages.campus-show', compact('campus'));
})->name('campuses.show');



Route::get('/ministries', function () {
    $ministries = Ministry::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    return view('pages.ministries', compact('ministries'));
})->name('ministries');

Route::get('/ministries/{ministry:slug}', function (Ministry $ministry) {
    abort_unless($ministry->is_published, 404);

    return view('pages.ministry-show', compact('ministry'));
})->name('ministries.show');

Route::get('/events', function () {
    $events = Event::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('event_date')
        ->get();

    return view('pages.events', compact('events'));
})->name('events');


Route::get('/gallery', function () {
    $albums = GalleryAlbum::query()
        ->where('is_published', true)
        ->withCount('images')
        ->with('images')
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->orderByDesc('album_date')
        ->get();

    return view('pages.gallery', compact('albums'));
})->name('gallery');

Route::get('/gallery/{galleryAlbum:slug}', function (GalleryAlbum $galleryAlbum) {
    abort_unless($galleryAlbum->is_published, 404);
    $galleryAlbum->load('images');

    return view('pages.gallery-show', ['album' => $galleryAlbum]);
})->name('gallery.show');

Route::get('/sermons', function () {
    $featured = Sermon::query()
        ->where('is_published', true)
        ->where('is_featured', true)
        ->first()
        ?? Sermon::query()
            ->where('is_published', true)
            ->orderByDesc('sermon_date')
            ->first();

    $sermons = Sermon::query()
        ->where('is_published', true)
        ->when($featured, fn ($query) => $query->whereKeyNot($featured->id))
        ->orderBy('sort_order')
        ->orderByDesc('sermon_date')
        ->get();

    return view('pages.sermons', compact('featured', 'sermons'));
})->name('sermons');


Route::get('/word-of-the-day', function () {
    $featured = DailyWord::where('is_published', true)->whereDate('publish_date', '<=', now()->toDateString())->where('is_featured', true)->first() ?? DailyWord::where('is_published', true)->whereDate('publish_date', '<=', now()->toDateString())->orderByDesc('publish_date')->first();
    $words = DailyWord::where('is_published', true)->whereDate('publish_date', '<=', now()->toDateString())->when($featured, fn ($q) => $q->whereKeyNot($featured->id))->orderByDesc('publish_date')->get();
    return view('pages.daily-words', compact('featured','words'));
})->name('daily-words');

Route::view('/plan-your-visit', 'pages.visit')->name('visit');
Route::view('/give', 'pages.give')->name('give');
Route::view('/contact', 'pages.contact')->name('contact');

Route::post('/prayer-requests', [PrayerRequestController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('prayer-requests.store');

Route::view('/admin', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::redirect('/dashboard', '/admin');

Route::middleware('auth')->group(function () {
    Route::resource('/admin/members', MemberController::class)
        ->names('admin.members');


    Route::get('/admin/prayer-requests', [AdminPrayerRequestController::class, 'index'])
        ->name('admin.prayer-requests.index');

    Route::get('/admin/prayer-requests/{prayerRequest}', [AdminPrayerRequestController::class, 'show'])
        ->name('admin.prayer-requests.show');

    Route::put('/admin/prayer-requests/{prayerRequest}', [AdminPrayerRequestController::class, 'update'])
        ->name('admin.prayer-requests.update');

    Route::delete('/admin/prayer-requests/{prayerRequest}', [AdminPrayerRequestController::class, 'destroy'])
        ->name('admin.prayer-requests.destroy');


    Route::resource('/admin/gallery', GalleryAlbumController::class)
        ->except('show')
        ->names('admin.gallery');

    Route::delete('/admin/gallery/{gallery}/images/{image}', [GalleryAlbumController::class, 'destroyImage'])
        ->name('admin.gallery.images.destroy');


    Route::resource('/admin/campuses', CampusController::class)
        ->except('show')
        ->names('admin.campuses');


    Route::get('/admin/bible-lookup', BibleLookupController::class)
        ->name('admin.bible.lookup');


    Route::resource('/admin/daily-words', DailyWordController::class)->except('show')->names('admin.daily-words');
    Route::resource('/admin/events', EventController::class)
        ->except('show')
        ->names('admin.events');

    Route::resource('/admin/ministries', MinistryController::class)
        ->except('show')
        ->names('admin.ministries');

    Route::resource('/admin/sermons', SermonController::class)
        ->except('show')
        ->names('admin.sermons');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
