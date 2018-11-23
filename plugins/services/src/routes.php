<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:services.manage"],
    "namespace" => "Dot\\Services\\Controllers"
], function ($route) {
    $route->group(["prefix" => "services"], function ($route) {
        $route->any('/', ["as" => "admin.services.show", "uses" => "ServicesController@index"]);
        $route->any('/create', ["as" => "admin.services.create", "uses" => "ServicesController@create"]);
        $route->any('/{service_id}/edit', ["as" => "admin.services.edit", "uses" => "ServicesController@edit"]);
        $route->any('/delete', ["as" => "admin.services.delete", "uses" => "ServicesController@delete"]);
        $route->any('/search', ["as" => "admin.services.search", "uses" => "ServicesController@search"]);
        $route->any('/{status}/status', ["as" => "admin.services.status", "uses" => "ServicesController@status"]);

        $route->group(["prefix" => "centers"], function ($route) {
            $route->any('/', ["as" => "admin.centers.show", "uses" => "CentersController@index"]);
            $route->any('/create', ["as" => "admin.centers.create", "uses" => "CentersController@create"]);
            $route->any('/{center_id}/edit', ["as" => "admin.centers.edit", "uses" => "CentersController@edit"]);
            $route->any('/delete', ["as" => "admin.centers.delete", "uses" => "CentersController@delete"]);
            $route->any('/search', ["as" => "admin.centers.search", "uses" => "CentersController@search"]);
            $route->any('/{status}/status', ["as" => "admin.centers.status", "uses" => "CentersController@status"]);
        });

    });
});
