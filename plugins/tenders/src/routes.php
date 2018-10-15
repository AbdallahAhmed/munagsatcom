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


        // tenders >> orgs
        $route->group(["prefix" => "orgs"], function ($route) {
            $route->any('/', ["as" => "admin.tenders.orgs.show", "uses" => "TenderOrgController@index"]);
            $route->any('/create', ["as" => "admin.tenders.orgs.create", "uses" => "TenderOrgController@create"]);
            $route->any('/{id}/edit', ["as" => "admin.tenders.orgs.edit", "uses" => "TenderOrgController@edit"]);
            $route->any('/delete', ["as" => "admin.tenders.orgs.delete", "uses" => "TenderOrgController@delete"]);
            $route->any('/{status}/status', ["as" => "admin.tenders.orgs.status", "uses" => "TenderOrgController@status"]);
        });


        // tenders >> activities
        $route->group(["prefix" => "activities"], function ($route) {
            $route->any('/', ["as" => "admin.tenders.activities.show", "uses" => "TenderActivityController@index"]);
            $route->any('/create', ["as" => "admin.tenders.activities.create", "uses" => "TenderActivityController@create"]);
            $route->any('/{id}/edit', ["as" => "admin.tenders.activities.edit", "uses" => "TenderActivityController@edit"]);
            $route->any('/delete', ["as" => "admin.tenders.activities.delete", "uses" => "TenderActivityController@delete"]);
            $route->any('/{status}/status', ["as" => "admin.tenders.activities.status", "uses" => "TenderActivityController@status"]);
        });
    });


});
