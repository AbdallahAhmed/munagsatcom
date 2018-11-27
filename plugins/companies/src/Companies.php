<?php

namespace Dot\Companies;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Companies extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("companies.manage")) {
                $menu->item('companies', trans("companies::companies.companies"), route("admin.companies.show"))->icon("fa-folder")->order(1);
            }
        });
    }
}
