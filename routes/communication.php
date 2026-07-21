<?php

use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Admin\CommunicationTemplateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/communication', [CommunicationController::class,'index'])->name('communication.index');
    Route::get('/communication/create', [CommunicationController::class,'create'])->name('communication.create');
    Route::post('/communication', [CommunicationController::class,'store'])->name('communication.store');
    Route::get('/communication/{communication}', [CommunicationController::class,'show'])->name('communication.show');
    Route::delete('/communication/{communication}', [CommunicationController::class,'destroy'])->name('communication.destroy');

    Route::get('/communication-templates', [CommunicationTemplateController::class,'index'])->name('communication.templates');
    Route::post('/communication-templates', [CommunicationTemplateController::class,'store'])->name('communication.templates.store');
    Route::delete('/communication-templates/{template}', [CommunicationTemplateController::class,'destroy'])->name('communication.templates.destroy');
});
