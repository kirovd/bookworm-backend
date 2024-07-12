<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ExternalBooksController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('books', BookController::class);
    Route::apiResource('favorites', FavoriteController::class);
    Route::get('/external-books', [ExternalBooksController::class, 'fetchBestSellers']);
});

Route::get('/favorites', [FavoriteController::class, 'index']);
Route::post('/favorites', [FavoriteController::class, 'store']);
Route::put('/favorites/{id}', [FavoriteController::class, 'update']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
