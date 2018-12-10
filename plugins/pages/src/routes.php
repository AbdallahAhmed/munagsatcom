<?php

/*
 * WEB
 */
Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:pages.manage"],
    "namespace" => "Dot\\Pages\\Controllers"
], function ($route) {
    $route->group(["prefix" => "pages"], function ($route) {
        $route->any('/', ["as" => "admin.pages.show", "uses" => "PagesController@index"]);
        $route->any('/create', ["as" => "admin.pages.create", "uses" => "PagesController@create"]);
        $route->any('/{id}/edit', ["as" => "admin.pages.edit", "uses" => "PagesController@edit"]);
        $route->any('/delete', ["as" => "admin.pages.delete", "uses" => "PagesController@delete"]);
        $route->any('/{status}/status', ["as" => "admin.pages.status", "uses" => "PagesController@status"]);
        $route->post('newSlug', 'PagesController@new_slug');
    });
});

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"],
    "namespace" => "Dot\\Pages\\Controllers"
], function ($route) {
    $route->get("/pages/show", "PagesApiController@show");
    $route->post("/pages/create", "PagesApiController@create");
    $route->post("/pages/update", "PagesApiController@update");
    $route->post("/pages/destroy", "PagesApiController@destroy");
});


