<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/greeting', function () {
    return response()->json(['message' => 'Hello from API!']);
});

Route::get('/legacy', [App\Http\Controllers\CebuLegacyController::class, 'showPublished'])
    ->name('legacy.isPublished');
Route::get('/legacy/{id}/details', [App\Http\Controllers\CebuLegacyController::class, 'showDetails'])
    ->name('legacy.details');
Route::get('/legacy/{id}/content', [App\Http\Controllers\CebuLegacyController::class, 'showContent'])
    ->name('legacy.content');

Route::get('/show-publish-review', [App\Http\Controllers\ReviewController::class, 'show'])
    ->name('reviews.show');
