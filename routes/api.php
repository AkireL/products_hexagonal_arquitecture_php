<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('user', UserController::class)->except(['show', 'index']);
Route::apiResource('products', ProductController::class)->except(['show', 'index']);
