<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductsController::class);
    Route::get('products/stock/{id}/{from}/{to}', [StockController::class, 'show'])->name('stockDetails');
    Route::resource('product_stock', StockController::class);

});
