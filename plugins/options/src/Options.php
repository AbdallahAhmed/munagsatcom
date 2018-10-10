<?php

namespace Dot\Options;

use Dot\Options\Facades\Option;
use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

/*
 * Class Options
 * @package Dot\Options
 */
class Options extends \Dot\Platform\Plugin
{

    /*
     * Plugin permissions
     * @var array
     */
    protected $permissions = [
        "manage"
    ];

    /*
     * Plugin aliases
     * @var array
     */
    protected $aliases = [
        'Option' => \Dot\Options\Facades\Option::class
    ];

    /*
     * Boot the plugin
     */
    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("options.manage")) {

                $menu->item('options', trans("admin::common.settings"), "")
                    ->order(30)
                    ->icon("fa-cogs");

                foreach (Option::pages() as $page) {

                    $menu->item('options.' . $page->name, $page->title, route("admin.options", ["page" => $page->name]))
                        ->icon($page->icon);

                }

            }

        });

        Navigation::menu("topnav", function ($menu) {
            if (Auth::user()->can("options.manage")) {
                $menu->make("options::dropmenu");
            }
        });

        require_once $this->getPath('helpers.php');
    }


    /*
     * Register some classes
     */
    function register()
    {
        parent::register();

        $this->app->bind("option", function () {
            return new \Dot\Options\Classes\Option($this->app);
        });
    }


}
