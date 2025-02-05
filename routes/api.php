<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/api/hello-world', function () {
    return 'Hello World';
});

Route::post('/api/products', [ProductController::class, 'store']);
