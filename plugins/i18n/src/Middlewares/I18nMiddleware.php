<?php

namespace Dot\I18n\Middlewares;

use Closure;
use Dot\I18n\Facades\I18n;

class I18nMiddleware
{
    public function handle($request, Closure $next)
    {

        // setting default locale

        if (config("i18n.driver") == "url") {

            // Getting current locale from the first url segment.

            if (!$request->is(config('admin.prefix') . "/*") and strstr(config("app.url"), $request->header('host'))) {

                if (!array_key_exists($request->segment(1), config('i18n.locales'))) {

                    $url = implode('/', $request->segments());

                    if ($request->getQueryString()) {
                        $url .= "?" . $request->getQueryString();
                    }

                    $url = $url ? $url : "/";

                    return redirect(url($url));

                } else {
                    app()->setLocale($request->segment(1));
                }

            }

            app()->setLocale($request->segment(1));

            if (isset(config()->get("i18n.locales")[app()->getLocale()]["direction"])) {
                define("DIRECTION", config()->get("i18n.locales")[app()->getLocale()]["direction"]);
            }

        } else {

            try {

                if (session()->has('locale')) {
                    app()->setLocale(session()->get('locale'));
                } else {
                    app()->setLocale(config()->get('app.locale'));
                }
                app()->setLocale('ar');

                define("DIRECTION", config()->get("i18n.locales")["ar"]["direction"]);

            } catch (Exception $error) {
                abort(500, "System locales is not configured successfully");
            }

        }

        return $next($request);
    }
}
