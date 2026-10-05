<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::post(
    '/login',
    [AuthController::class, 'login']
);

Route::middleware('jwt')->group(function () {

    Route::get(
        '/profile',
        [AuthController::class, 'profile']
    );

    Route::get(
        '/products',
        [ProductController::class, 'index']
    );

    Route::get(
        '/products/{id}',
        [ProductController::class, 'show']
    );

    Route::post(
        '/products',
        [ProductController::class, 'store']
    );

    Route::put(
        '/products/{id}',
        [ProductController::class, 'update']
    );

    Route::delete(
        '/products/{id}',
        [ProductController::class, 'destroy']
    );
});