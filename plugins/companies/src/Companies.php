<?php

namespace Dot\Companies;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Companies extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage",
        "transactions"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("companies.manage")) {
                $menu->item('companies', trans("companies::companies.companies"), route("admin.companies.show"))->icon("fa-folder")->order(1);
            }
        });

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("companies.transactions")) {
                $menu->item('companies', trans("companies::companies.transactions"), route("admin.companies.transactions"))->icon("fa-money")->order(2);
            }
        });
    }
}
