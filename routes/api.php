<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Domain\Product\Controllers\ProductController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

    Route::prefix('products')->group(function () {

        Route::get('/list', [ProductController::class, 'index']);

        Route::post('/create', [ProductController::class, 'store']);

        Route::put('/update/{id}', [ProductController::class, 'update']);

        Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
    });
