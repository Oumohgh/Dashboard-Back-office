<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerantController;

Route::middleware(['auth', 'gerant'])->prefix('gerant')->name('gerant.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [GerantController::class, 'dashboard'])->name('dashboard');
    
    // Hotels - Full CRUD
    Route::resource('hotels', GerantController::class);
});
