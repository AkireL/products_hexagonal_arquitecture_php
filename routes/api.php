<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('user', UserController::class)->except(['show', 'index']);
Route::apiResource('product', ProductController::class);
Route::apiResource('user/order', OrderController::class)->only(['show', 'store']);
Route::post('user/order/{order}/product', [OrderController::class, 'clear']);
