<?php

namespace Dot\Categories;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Categories extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("categories.manage")) {
                $menu->item('categories', trans("categories::categories.categories"), route("admin.categories.show"))->icon("fa-folder")->order(1);
            }
        });
    }
}
