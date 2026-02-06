<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/hotels', [AdminController::class, 'hotels'])->name('hotels.index');
    Route::post('/hotels/{hotel}/approve', [AdminController::class, 'approve'])->name('hotels.approve');
    Route::post('/hotels/{hotel}/reject', [AdminController::class, 'reject'])->name('hotels.reject');
});
