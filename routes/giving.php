<?php

use App\Http\Controllers\Admin\GivingMethodController;
use App\Models\GivingMethod;
use Illuminate\Support\Facades\Route;

Route::get('/give', function () {
    $givingMethods = GivingMethod::query()
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();

    return view('pages.give', compact('givingMethods'));
})->name('give');

Route::middleware(['auth', 'role:super_admin,senior_pastor,admin'])->group(function () {
    Route::resource('/admin/giving-methods', GivingMethodController::class)
        ->except('show')
        ->names('admin.giving-methods');
});
