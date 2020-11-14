<?php

use Illuminate\Http\Request;

use Illuminate\Contracts\Http\Kernel;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists(__DIR__ . '/../storage/framework/maintenance.php')) {
    require __DIR__ . '/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle($request = Request::capture()))->send();

$kernel->terminate($request, $response);
