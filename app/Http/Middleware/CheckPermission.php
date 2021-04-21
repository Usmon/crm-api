<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

final class CheckPermission
{
    /**
     * @param Request $request
     *
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        dd(auth()->user()->roles, $request->route()->getName());
        return $next($request);
    }
}
