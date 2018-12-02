<?php

namespace App\Http\Middleware;

use Closure;
use Dot\Auth\Auth;

class RedirectIfCompany
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
        if(fauth()->check() && fauth()->user()->type == 2)
            return $next($request);
        else return redirect()->route('index');
    }
}
