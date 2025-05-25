<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\TourController::class,'index'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/cebu-legacy',[App\Http\Controllers\CebuLegacyController::class, 'index'])->name('cebu-legacy');
    Route::get('/cebu-legacy/{id}', [App\Http\Controllers\CebuLegacyController::class, 'show'])->name('cebu-legacy.show');
    Route::get('/vehicle-routes', [App\Http\Controllers\VehicleRouteController::class, 'index'])->name('cebu-legacy.edit');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])
        ->name('messages.index');
});

Route::post('/message-post', [App\Http\Controllers\MessageController::class, 'store'])
    ->name('messages.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
