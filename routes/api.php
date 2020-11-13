<?php

use App\Helper\Json;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\Login as AuthLoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Json::sendJsonWith200([
        'app' => [
            'name' => config('app.name'),
            'version' => config('app.version'),
        ],
    ]);
})->name('app');

// Authentication routes
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('login', AuthLoginController::class)->name('login');
});

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});
