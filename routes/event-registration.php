<?php

use App\Http\Controllers\Admin\EventRegistrationController as AdminEventRegistrationController;
use App\Http\Controllers\EventRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/events/{event}/register', [EventRegistrationController::class, 'create'])
    ->name('event-registration.create');

Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])
    ->middleware('throttle:public-forms')
    ->name('event-registration.store');

Route::get(
    '/events/{event}/registration/{registration}/success',
    [EventRegistrationController::class, 'success']
)->middleware('signed')->name('event-registration.success');

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get(
            '/event-registrations',
            [AdminEventRegistrationController::class, 'index']
        )->name('event-registrations.index');

        Route::get(
            '/event-registrations/{event}/export',
            [AdminEventRegistrationController::class, 'export']
        )->name('event-registrations.export');

        Route::get(
            '/event-registrations/{event}/{registration}',
            [AdminEventRegistrationController::class, 'details']
        )->name('event-registrations.details');

        Route::get(
            '/event-registrations/{event}',
            [AdminEventRegistrationController::class, 'show']
        )->name('event-registrations.show');

        Route::patch(
            '/event-registrations/{event}/{registration}/status',
            [AdminEventRegistrationController::class, 'updateStatus']
        )->name('event-registrations.status');

        Route::patch(
            '/event-registrations/{event}/{registration}/check-in',
            [AdminEventRegistrationController::class, 'checkIn']
        )->name('event-registrations.check-in');

        Route::delete(
            '/event-registrations/{event}/{registration}/check-in',
            [AdminEventRegistrationController::class, 'undoCheckIn']
        )->name('event-registrations.undo-check-in');
    });
