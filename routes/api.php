<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/api/hello-world', function () {
    return 'Hello World';
});

Route::post('/api/products', [ProductController::class, 'store']);

Route::post('/api/orders', [OrderController::class, 'create'])->name('orders.create');
Route::post('/api/orders/{orderId}/capture', [OrderController::class, 'capture'])->name('orders.capture');

Route::get('/api/cart/fetch', [CartController::class, 'fetch'])->name('cart.fetch');
