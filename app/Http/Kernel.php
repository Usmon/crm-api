<?php

namespace App\Http;

use App\Http\Middleware\Auth;

use App\Http\Middleware\Guest;

use App\Http\Middleware\TrimStrings;

use App\Http\Middleware\TrustProxies;

use Illuminate\Auth\Middleware\Authorize;

use Illuminate\Routing\Middleware\SubstituteBindings;

use Illuminate\Foundation\Http\Kernel as Http;

use Illuminate\Foundation\Http\Middleware\ValidatePostSize;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;

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
        ],
    ];

    /**
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Auth::class,
        'can' => Authorize::class,
        'guest' => Guest::class,
        'bindings' => SubstituteBindings::class,
    ];
}
