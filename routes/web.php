<?php

use App\Http\Controllers\Admin\BladeProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('home');

// Product Resource Route
Route::resource('blade-products', BladeProductController::class);
// Search Route
Route::get('/products/search', SearchController::class)->name('products.search');
