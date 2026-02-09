<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/gerant.php';
