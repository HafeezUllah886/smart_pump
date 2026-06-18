<?php

use App\Http\Controllers\AttendantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('attendants', AttendantController::class);
});
