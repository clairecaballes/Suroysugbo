<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/greeting', function () {
    return response()->json(['message' => 'Hello from API!']);
});

Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])
    ->name('messages.store');
