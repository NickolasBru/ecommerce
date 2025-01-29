<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Route::get('/', function () {
    return ['success' => true];
});

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    // Protected Routes - Requires Authentication
    Route::middleware('auth:sanctum')->group(function () {

        // categories Routes
        Route::get('/categories', [CategoryController::class, 'index']);
        // Product Routes
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('{id}', [ProductController::class, 'show']);
            Route::post('/', [ProductController::class, 'store']);
            Route::put('{id}', [ProductController::class, 'update']);
            Route::delete('{id}', [ProductController::class, 'destroy']);
        });

        // Cart Routes
        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index']);
            Route::get('{id}', [CartController::class, 'show']);
            Route::post('/', [CartController::class, 'addToCart']);
            Route::put('{id}', [CartController::class, 'update']);
            Route::delete('{id}', [CartController::class, 'destroy']);
        });

    });

});
