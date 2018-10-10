<?php

namespace Dot\Blocks;

use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

class Blocks extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("blocks.manage")) {
                $menu->item('blocks', trans("blocks::blocks.blocks"), route("admin.blocks.show"))->icon("fa-th-large")->order(4);
            }

        });
    }
}
