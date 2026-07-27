<?php
use App\Http\Controllers\Admin\LibraryCategoryController;
use App\Http\Controllers\Admin\LibraryResourceController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/elibrary',[LibraryController::class,'index'])->name('library.index');
Route::get('/elibrary/{resource:slug}',[LibraryController::class,'show'])->name('library.show');
Route::get('/elibrary/{resource:slug}/read',[LibraryController::class,'read'])->name('library.read');
Route::get('/elibrary/{resource:slug}/download',[LibraryController::class,'download'])->middleware('throttle:downloads')->name('library.download');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('library-categories',LibraryCategoryController::class)->except('show');
    Route::resource('library-resources',LibraryResourceController::class)->except('show');
});
