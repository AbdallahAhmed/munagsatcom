<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:tenders.manage"],
    "namespace" => "Dot\\Tenders\\Controllers"
], function ($route) {


    // tenders
    $route->group(["prefix" => "tenders"], function ($route) {
        $route->any('/', ["as" => "admin.tenders.show", "uses" => "TenderController@index"]);
        $route->any('/create', ["as" => "admin.tenders.create", "uses" => "TenderController@create"]);
        $route->any('/{id}/edit', ["as" => "admin.tenders.edit", "uses" => "TenderController@edit"]);
        $route->any('/delete', ["as" => "admin.tenders.delete", "uses" => "TenderController@delete"]);
        $route->any('/{status}/status', ["as" => "admin.tenders.status", "uses" => "TenderController@status"]);

        // tenders >> types
        $route->group(["prefix" => "types"], function ($route) {
            $route->any('/', ["as" => "admin.tenders.types.show", "uses" => "TenderTypeController@index"]);
            $route->any('/create', ["as" => "admin.tenders.types.create", "uses" => "TenderTypeController@create"]);
            $route->any('/{id}/edit', ["as" => "admin.tenders.types.edit", "uses" => "TenderTypeController@edit"]);
            $route->any('/delete', ["as" => "admin.tenders.types.delete", "uses" => "TenderTypeController@delete"]);
            $route->any('/{status}/status', ["as" => "admin.tenders.types.status", "uses" => "TenderTypeController@status"]);
        });
    });


});
