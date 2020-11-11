<?php

namespace App\Http;

use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\PreventRequestsDuringMaintenance;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\SubstituteBindings;

use Illuminate\Foundation\Http\Kernel as Http;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

use Fruitcake\Cors\HandleCors;

final class Kernel extends Http
{
    /**
     * @var array
     */
    protected $middleware = [
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'bindings',
            'throttle:api',
        ],
    ];

    /**
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'bindings' => SubstituteBindings::class,
        'throttle' => ThrottleRequests::class,
    ];
}
