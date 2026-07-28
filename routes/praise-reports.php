<?php
use App\Http\Controllers\PraiseReportController;
use App\Http\Controllers\PraiseReportCommentController;
use App\Http\Controllers\PraiseReportReactionController;
use App\Http\Controllers\Admin\PraiseReportController as AdminPraiseReportController;
use App\Http\Controllers\Admin\PraiseReportCommentController as AdminPraiseReportCommentController;
use Illuminate\Support\Facades\Route;

Route::get('/praise-reports',[PraiseReportController::class,'index'])->name('praise-reports.index');
Route::get('/praise-reports/{praiseReport:slug}',[PraiseReportController::class,'show'])->name('praise-reports.show');
Route::post('/praise-reports/{praiseReport:slug}/reactions',[PraiseReportReactionController::class,'store'])->middleware('throttle:public-forms')->name('praise-reports.reactions.store');
Route::post('/praise-reports/{praiseReport:slug}/encouragements',[PraiseReportCommentController::class,'store'])->middleware('throttle:public-forms')->name('praise-reports.comments.store');
Route::middleware('auth')->group(function(){
 Route::resource('/admin/praise-reports',AdminPraiseReportController::class)->except('show')->names('admin.praise-reports');
 Route::get('/admin/praise-report-encouragements',[AdminPraiseReportCommentController::class,'index'])->name('admin.praise-reports.comments.index');
 Route::patch('/admin/praise-report-encouragements/{comment}/approve',[AdminPraiseReportCommentController::class,'approve'])->name('admin.praise-reports.comments.approve');
 Route::patch('/admin/praise-report-encouragements/{comment}/reject',[AdminPraiseReportCommentController::class,'reject'])->name('admin.praise-reports.comments.reject');
 Route::delete('/admin/praise-report-encouragements/{comment}',[AdminPraiseReportCommentController::class,'destroy'])->name('admin.praise-reports.comments.destroy');
});
