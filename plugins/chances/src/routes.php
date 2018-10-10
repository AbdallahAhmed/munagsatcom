<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:chances.manage"],
    "namespace" => "Dot\\Chances\\Controllers"
], function ($route) {

    //Chances
    $route->group(["prefix" => "chances"], function ($route) {
        $route->any('/', ["as" => "admin.chances.show", "uses" => "ChancesController@index"]);
        $route->any('/create', ["as" => "admin.chances.create", "uses" => "ChancesController@create"]);
        $route->any('/{chance_id}/edit', ["as" => "admin.chances.edit", "uses" => "ChancesController@edit"]);
        $route->any('/delete', ["as" => "admin.chances.delete", "uses" => "ChancesController@delete"]);
        $route->any('/search', ["as" => "admin.chances.search", "uses" => "ChancesController@search"]);
    });

    //Units
    $route->group(["prefix" => "units"], function ($route) {
        $route->any('/', ["as" => "admin.units.show", "uses" => "UnitsController@index"]);
        $route->any('/create', ["as" => "admin.units.create", "uses" => "UnitsController@create"]);
        $route->any('/{unit_id}/edit', ["as" => "admin.units.edit", "uses" => "UnitsController@edit"]);
        $route->any('/delete', ["as" => "admin.units.delete", "uses" => "UnitsController@delete"]);
        $route->any('/search', ["as" => "admin.units.search", "uses" => "UnitsController@search"]);
        $route->any('/status', ["as" => "admin.units.status", "uses" => "UnitsController@status"]);
    });

    //Sectors
    $route->group(["prefix" => "sectors"], function ($route) {
        $route->any('/', ["as" => "admin.sectors.show", "uses" => "SectorsController@index"]);
        $route->any('/create', ["as" => "admin.sectors.create", "uses" => "SectorsController@create"]);
        $route->any('/{sector_id}/edit', ["as" => "admin.sectors.edit", "uses" => "SectorsController@edit"]);
        $route->any('/delete', ["as" => "admin.sectors.delete", "uses" => "SectorsController@delete"]);
        $route->any('/search', ["as" => "admin.sectors.search", "uses" => "SectorsController@search"]);
        $route->any('/status', ["as" => "admin.sectors.status", "uses" => "SectorsController@status"]);
    });
});
