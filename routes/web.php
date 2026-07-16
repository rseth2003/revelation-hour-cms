<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MinistryController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use App\Models\Ministry;
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

    return view('home', compact('events', 'ministries'));
})->name('home');

Route::view('/about', 'pages.about')->name('about');

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

    Route::resource('/admin/ministries', MinistryController::class)
        ->except('show')
        ->names('admin.ministries');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
