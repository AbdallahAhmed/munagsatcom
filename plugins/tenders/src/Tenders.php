<?php

namespace Dot\Tenders;


use Navigation;
use URL;

class Tenders extends \Dot\Platform\Plugin
{

    /*
     * @var array
     */
    protected $dependencies = [
        "categories" => \Dot\Categories\Categories::class,
    ];

    /**
     * @var array
     */
    protected $permissions = [
        "manage"
    ];

    /**
     *  initialize plugin
     */
    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (\Auth::user()->can("tenders.manage")) {

                $menu->item('tenders', trans("tenders::tenders.tenders"), route('admin.tenders.show'))
                    ->order(1)
                    ->icon(" fa-clone");

                $menu->item('tenders.types', trans("tenders::types.types"), route('admin.tenders.types.show'))
                    ->order(1)
                    ->icon(" fa-clone");


                $menu->item('tenders.orgs', trans("tenders::orgs.orgs"), route('admin.tenders.orgs.show'))
                    ->order(2)
                    ->icon("fa-globe");


                $menu->item('tenders.activities', trans("tenders::activities.activities"), route('admin.tenders.activities.show'))
                    ->order(2)
                    ->icon("fa-cube");


                if (\Auth::user()->can("categories.manage")) {
                    $menu->item('tenders.categories', trans("categories::categories.categories"), route("admin.categories.show"))->icon("fa-folder")->order(0);

                    if (\Auth::user()->can("i18n.manage_places")) {
                        $menu->item('tenders.splaces', trans("i18n::places.places"), route("admin.places.show"))
                            ->order(5.5)
                            ->icon("fa-map-marker");
                    }
                }

            }
        });
    }
}
