<?php

use App\Http\Controllers\Admin\BladeProductController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('home');

Route::resource('blade-products', BladeProductController::class);
