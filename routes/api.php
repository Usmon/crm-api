<?php

use App\Helpers\Json;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\Login as AuthLoginController;

use App\Http\Controllers\Auth\Logout as AuthLogoutController;

use App\Http\Controllers\Auth\Register as AuthRegisterController;

use App\Http\Controllers\User\Controller as UserController;

use App\Http\Controllers\User\Sessions\Controller as UserSessionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// App routers
Route::name('app')->get('/', function () {
    return Json::sendJsonWith200([
        'app' => [
            'name' => config('app.name'),

            'version' => config('app.version'),
        ],
    ]);
});

// Authentication routes
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', AuthLoginController::class)->name('login');

    Route::post('logout', AuthLogoutController::class)->name('logout');

    Route::post('register', AuthRegisterController::class)->name('register');
});

// User routes
Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::get('/', UserController::class)->name('user');

    Route::group(['prefix' => 'sessions', 'as' => 'sessions.'], function () {
        Route::get('/', [UserSessionsController::class, 'index'])->name('index');

        Route::delete('other', [UserSessionsController::class, 'other'])->name('other');

        Route::delete('{token}', [UserSessionsController::class, 'delete'])->name('delete');
    });
});
