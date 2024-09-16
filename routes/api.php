<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('admin')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('attributes', AttributeController::class);
    Route::apiResource('products', ProductController::class);
});

Route::get('test', function () {
    $product  = \App\Models\Product::find(1)->first()->with('attributes');
    return $product;
    $attributes = $product->attributes;
    return $attributes;
});
