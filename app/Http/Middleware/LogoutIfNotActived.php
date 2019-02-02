<?php

namespace App\Http\Middleware;

use Closure;

class LogoutIfNotActived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (fauth()->check()) {
            if (fauth()->user()->status == 0) {
                fauth()->logout();
            }
        }
        return $next($request);
    }
}
