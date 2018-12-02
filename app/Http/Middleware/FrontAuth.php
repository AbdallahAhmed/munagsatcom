<?php

namespace App\Http\Middleware;

use Closure;

class FrontAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!fauth()->check())
            return redirect()->route('index');
        return $next($request);
    }
}
