<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\TourController::class,'index'])->name('home');
Route::get('/about', [App\Http\Controllers\AboutController::class,'index'])->name('about');
Route::get('/gallery', [App\Http\Controllers\GalleryController::class,'index'])->name('gallery');
Route::get('/contact', [App\Http\Controllers\ContactController::class,'index'])->name('contact');
Route::get('/faq', [App\Http\Controllers\FaqController::class,'index'])->name('faq');
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/cebu-legacy',[App\Http\Controllers\CebuLegacyController::class, 'index'])->name('cebu-legacy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
