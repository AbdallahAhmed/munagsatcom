<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;

class Localization
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

        $lang = $request->route()->parameter('lang');
        if ($lang == null) {
            $lang = 'ar';
        }

        if (!($lang == "ar" || $lang == "en")) {
            abort(404);
        }
        Carbon::setLocale($lang);
        \Carbon\Carbon::setLocale($lang);
        app()->setLocale($lang);
        $request->route()->forgetParameter('lang');
        app('url')->defaults(['lang' => $lang]);


        return $next($request);
    }
}
