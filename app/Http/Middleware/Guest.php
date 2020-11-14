<?php

namespace App\Http\Middleware;

use Closure;

use App\Helper\Json;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Factory;

final class Guest
{
    /**
     * @var Factory
     */
    protected $auth;

    /**
     * @param Factory $auth
     *
     * @return void
     */
    public function __construct(Factory $auth)
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
                return Json::sendJsonWith400([
                    'message' => 'You are already authorized.',
                ]);
            }
        }

        return $next($request);
    }
}
