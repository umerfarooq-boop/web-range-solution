<?php

use App\Http\Controllers\Api\ExternalPostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ScraperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HttpRequestController;





Route::prefix('product')->group(function () {
    Route::get('/',       [ProductController::class, 'index']);
    Route::post('/store',      [ProductController::class, 'store']);
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('external')->group(function () {
    Route::get('/posts', [ExternalPostController::class, 'index']);
});

Route::prefix('scrape')->group(function () {
    Route::get('/', [ScraperController::class, 'index']);
});

Route::prefix('http-demo')->group(function () {
    Route::get('/', [HttpRequestController::class, 'index']);
});
