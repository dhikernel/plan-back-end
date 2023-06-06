<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Domain\Product\Controllers\ProductController;

    Route::prefix('products')->group(function () {

        Route::get('/list', [ProductController::class, 'index']);

        Route::get('/edit/{id}', [ProductController::class, 'edit']);

        Route::post('/create', [ProductController::class, 'store']);

        Route::put('/update/{id}', [ProductController::class, 'update']);

        Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
    });
