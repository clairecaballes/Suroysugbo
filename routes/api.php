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

Route::get('/show-publish-review', [App\Http\Controllers\ReviewController::class, 'show'])
    ->name('reviews.show');
