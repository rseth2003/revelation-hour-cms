<?php
use App\Http\Controllers\WebsiteFeedbackController;
use App\Http\Controllers\Admin\WebsiteFeedbackController as AdminWebsiteFeedbackController;
use App\Http\Controllers\Admin\FaqController;
use Illuminate\Support\Facades\Route;
Route::post('/website-feedback',[WebsiteFeedbackController::class,'store'])->middleware('throttle:public-forms')->name('website-feedback.store');
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
 Route::resource('feedback',AdminWebsiteFeedbackController::class)->only(['index','show','update','destroy']);
 Route::resource('faqs',FaqController::class)->except('show');
});
