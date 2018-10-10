<?php

namespace Dot\I18n;

use Action;
use Dot\I18n\Classes\DotUrlGenerator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Navigation;

class I18n extends \Dot\Platform\Plugin
{

    protected $middlewares = [
        Middlewares\I18nMiddleware::class
    ];

    protected $permissions = [
        'manage_places'
    ];

    protected $facades = [
        'I18n' => Facades\I18n::class
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("i18n.manage_places")) {
                $menu->item('places', trans("i18n::places.places"), route("admin.places.show"))
                    ->order(5.5)
                    ->icon("fa-map-marker");
            }
        });

        $this->app->bind('i18n', function ($app) {
            return new Classes\I18n($app);
        });

        Navigation::menu("topnav", function ($menu) {
            $menu->make("i18n::locales");
        });

//        Navigation::menu("topnav", function ($menu) {
//            $menu->make("i18n::countries");
//        });
    }

    function register()
    {

        parent::register();

        if (config("i18n.driver") == "url") {

            $request = $this->app->make('request');

            /* Redirect backend urls have no locale code */

            if ($request->is(config('admin.prefix') . "/*")) {

                $url = implode('/', array_prepend($request->segments(), $this->app->getLocale()));

                if ($request->getQueryString()) {
                    $url .= "?" . $request->getQueryString();
                }

                redirect($url)->send();
            }

            Config::set("admin.prefix", $request->segment(1) . "/" . config("admin.prefix"));

            app()->bind('url', function () {
                return new DotUrlGenerator(
                    app()->make('router')->getRoutes(),
                    app()->make('request')
                );
            });

        }
    }
}
