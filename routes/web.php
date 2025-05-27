<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\TourController::class,'index'])->name('home');
Route::get('/cebu-legacy/view/{id}', [App\Http\Controllers\TourController::class,'view'])->name('view');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/cebu-legacy',[App\Http\Controllers\CebuLegacyController::class, 'index'])->name('cebu-legacy');
    Route::get('/cebu-legacy/edit', [App\Http\Controllers\CebuLegacyController::class, 'create'])->name('cebu-legacy.create');
    Route::post('/cebu-legacy/store', [App\Http\Controllers\CebuLegacyController::class, 'store'])->name('cebu-legacy.store');
    Route::get('/cebu-legacy/edit/{id}', [App\Http\Controllers\CebuLegacyController::class, 'edit'])->name('cebu-legacy.edit');
    // Route::get('/cebu-legacy/{id}', [App\Http\Controllers\CebuLegacyController::class, 'show'])->name('cebu-legacy.show');
    Route::get('/vehicle-routes', [App\Http\Controllers\VehicleRouteController::class, 'index'])->name('cebu-legacy.edit');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])
        ->name('messages.index');
    Route::get('/messages/{id}/read/', [App\Http\Controllers\MessageController::class, 'read'])
        ->name('messages.read');
});

Route::post('/message-post', [App\Http\Controllers\MessageController::class, 'store'])
    ->name('messages.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
