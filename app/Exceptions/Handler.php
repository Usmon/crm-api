<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as Exceptions;

final class Handler extends Exceptions
{
    /**
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        //
    }
}
