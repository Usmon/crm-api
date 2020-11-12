<?php

namespace App\Http\Middleware;

use Closure;

use App\Helper\Json;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Factory as Auth;

final class Authenticate
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
            if ($this->auth->guard($guard)->guest()) {
                return Json::sendJsonWith401([
                    'message' => 'You are not authorized.',
                ]);
            }
        }

        return $next($request);
    }
}
