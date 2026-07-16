<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
Route::view('/', 'home')->name('home');
Route::view('/admin', 'dashboard')->middleware('auth')->name('dashboard');
Route::redirect('/dashboard', '/admin');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
