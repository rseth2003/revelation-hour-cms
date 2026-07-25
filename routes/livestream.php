<?php
use App\Http\Controllers\Admin\LivestreamController as AdminLivestreamController;
use App\Http\Controllers\LivestreamController;
use Illuminate\Support\Facades\Route;

Route::get('/livestream',[LivestreamController::class,'index'])->name('livestreams.index');
Route::get('/livestream/{livestream:slug}',[LivestreamController::class,'show'])->name('livestreams.show');
Route::middleware(['auth','role:super_admin,senior_pastor,admin,media_team'])->prefix('admin')->name('admin.')->group(function(){
 Route::post('livestreams/{livestream}/duplicate',[AdminLivestreamController::class,'duplicate'])->name('livestreams.duplicate');
 Route::resource('livestreams',AdminLivestreamController::class)->except('show');
});
