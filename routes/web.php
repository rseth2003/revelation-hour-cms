<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

function rhmiMinistries(): array
{
    return [
        [
            'slug' => 'prayer',
            'name' => 'Prayer Ministry',
            'short' => 'Prayer',
            'summary' => 'Intercession, prayer gatherings and spiritual support.',
            'description' => 'Helping individuals and families seek God through intercession, corporate prayer and spiritual support.',
        ],
        [
            'slug' => 'worship',
            'name' => 'Worship Ministry',
            'short' => 'Worship',
            'summary' => 'Leading people into God’s presence through worship and music.',
            'description' => 'Serving through music, worship leadership and creative expression.',
        ],
        [
            'slug' => 'youth',
            'name' => 'Youth and Young Adults',
            'short' => 'Youth',
            'summary' => 'Equipping young people in faith, purpose and leadership.',
            'description' => 'A place for young people to know Christ, build relationships and discover purpose.',
        ],
        [
            'slug' => 'children',
            'name' => 'Children’s Ministry',
            'short' => 'Children',
            'summary' => 'Helping children know Jesus in a safe and joyful environment.',
            'description' => 'Partnering with families to help children understand the Bible and experience worship.',
        ],
        [
            'slug' => 'women',
            'name' => 'Women and Families',
            'short' => 'Women',
            'summary' => 'Encouraging women and strengthening homes.',
            'description' => 'Discipleship, encouragement, prayer and practical support for women and families.',
        ],
        [
            'slug' => 'outreach',
            'name' => 'Evangelism and Outreach',
            'short' => 'Outreach',
            'summary' => 'Sharing the Gospel and serving communities.',
            'description' => 'Taking the message and love of Jesus beyond the church walls.',
        ],
    ];
}

Route::get('/', function () {
    $ministries = rhmiMinistries();

    $events = Event::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('event_date')
        ->limit(12)
        ->get();

    return view('home', compact('events', 'ministries'));
})->name('home');

Route::view('/about', 'pages.about')->name('about');

Route::get('/ministries', function () {
    $ministries = rhmiMinistries();

    return view('pages.ministries', compact('ministries'));
})->name('ministries');

Route::get('/ministries/{slug}', function (string $slug) {
    $ministry = collect(rhmiMinistries())->firstWhere('slug', $slug);

    abort_unless($ministry, 404);

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

Route::view('/sermons', 'pages.sermons')->name('sermons');
Route::view('/plan-your-visit', 'pages.visit')->name('visit');
Route::view('/give', 'pages.give')->name('give');
Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/admin', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::redirect('/dashboard', '/admin');

Route::middleware('auth')->group(function () {
    Route::resource('/admin/events', EventController::class)
        ->except('show')
        ->names('admin.events');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
