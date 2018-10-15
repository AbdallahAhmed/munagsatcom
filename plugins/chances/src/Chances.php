<?php

namespace Dot\Chances;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Chances extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("chances.manage")) {
                $menu->item('chances', trans("chances::chances.chances"), '')->icon("fa-align-left")->order(4);
            }
            if (Auth::user()->can("chances.manage")) {
                $menu->item('chances.units', trans("chances::units.units"), route("admin.units.show"))->icon("fa-balance-scale")->order(4);
            }
            if (Auth::user()->can("chances.manage")) {
                $menu->item('chances.sectors', trans("chances::sectors.sectors"), route("admin.sectors.show"))->icon("fa-th-large")->order(4);
            }
            if (Auth::user()->can("chances.manage")) {
                $menu->item('chances.chances', trans("chances::chances.side_bar"), route("admin.chances.show"))->icon("fa-align-left")->order(4);
            }


        });
    }
}
