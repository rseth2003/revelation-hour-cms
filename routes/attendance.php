<?php

use App\Http\Controllers\Admin\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('attendance', AttendanceController::class)
            ->parameters(['attendance' => 'attendance'])
            ->except(['store']);
        Route::post('/attendance', [AttendanceController::class, 'store'])
            ->name('attendance.store');
    });
