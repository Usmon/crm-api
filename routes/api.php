<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\App as AppController;

use App\Http\Controllers\Auth\Login as AuthLoginController;

use App\Http\Controllers\Auth\Logout as AuthLogoutController;

use App\Http\Controllers\Auth\Register as AuthRegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// App routers
Route::get('/', AppController::class)->name('app');

// Authentication routes
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', AuthLoginController::class)->name('login');
    Route::post('logout', AuthLogoutController::class)->name('logout');
    Route::post('register', AuthRegisterController::class)->name('register');
});
