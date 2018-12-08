<?php

namespace App\Http\Middleware;

use Closure;

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
        if (!($lang == 'ar' && $lang == 'en')) {
            $lang = 'ar'; //default
        }

        Carbon::setLocale($lang);
        \Carbon\Carbon::setLocale($lang);
        // The lang ar only
        /* if ($lang == "en") {
             return redirect()->route('index', ['lang' => 'ar']);
         }*/

        app()->setLocale($lang);

        $request->route()->forgetParameter('lang');
        app('url')->defaults(['lang' => $lang]);


        return $next($request);
    }
}
