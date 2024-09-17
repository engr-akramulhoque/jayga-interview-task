<?php

use App\Http\Controllers\Admin\BladeProductController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class);
Route::resource('blade-products', BladeProductController::class);
