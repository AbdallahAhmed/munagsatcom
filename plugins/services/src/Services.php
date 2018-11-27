<?php

namespace Dot\Services;

use Illuminate\Support\Facades\Auth;
use Navigation;

class Services extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("services.manage")) {
                $menu->item('services', trans("services::services.services"), route("admin.services.show"))->icon("fa-th-large")->order(4);
            }
            if (Auth::user()->can("services.manage")) {
                $menu->item('services.centers', trans("services::centers.centers"), route("admin.centers.show"))->icon("fa fa-archive")->order(4);
            }
            if(Auth::user()->can("users")){
                $menu->item('points', trans("services::points.points"), route("admin.points"))->icon("fa fa-archive")->order(10);
            }
        });
    }
}
