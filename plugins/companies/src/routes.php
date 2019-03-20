<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:companies.manage"],
    "namespace" => "Dot\\Companies\\Controllers"
], function ($route) {
    $route->group(["prefix" => "companies"], function ($route) {
        $route->any('/transactions', ["as" => "admin.companies.transactions", "uses" => "CompaniesController@transactions"]);
        $route->any('/create', ["as" => "admin.companies.create", "uses" => "CompaniesController@create"]);
        $route->any('/delete', ["as" => "admin.companies.delete", "uses" => "CompaniesController@delete"]);
        $route->any('/{id?}', ["as" => "admin.companies.show", "uses" => "CompaniesController@index"]);
        $route->any('/{id}/edit', ["as" => "admin.companies.edit", "uses" => "CompaniesController@edit"]);
    });
});

