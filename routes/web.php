<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\TourController::class,'index'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/cebu-legacy',[App\Http\Controllers\CebuLegacyController::class, 'index'])->name('cebu-legacy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
