<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GlobalSearchController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('admin')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('attributes', AttributeController::class);
    Route::apiResource('products', ProductController::class);

    // search api route
    Route::get('/search/products', [GlobalSearchController::class, '__invoke']);
});
