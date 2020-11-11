<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Contracts\Auth\Factory as Auth;

final class RedirectIfAuthenticated
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @param Auth $auth
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @param string|null ...$guards
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return Response::json([
                    'success' => false,
                    'message' => 'Bad request.',
                ], 400);
            }
        }

        return $next($request);
    }
}
