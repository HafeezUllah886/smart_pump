<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/products_mgmt.php';
require __DIR__.'/finance.php';
require __DIR__.'/settings.php';

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('dashboard');

});
