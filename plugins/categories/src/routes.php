<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:categories.manage"],
    "namespace" => "Dot\\Categories\\Controllers"
], function ($route) {
    $route->group(["prefix" => "categories"], function ($route) {
        $route->any('/create', ["as" => "admin.categories.create", "uses" => "CategoriesController@create"]);
        $route->any('/delete', ["as" => "admin.categories.delete", "uses" => "CategoriesController@delete"]);
        $route->any('/{id?}', ["as" => "admin.categories.show", "uses" => "CategoriesController@index"]);
        $route->any('/{id}/edit', ["as" => "admin.categories.edit", "uses" => "CategoriesController@edit"]);
    });
});

/*
 * API
 */

Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"],
    "namespace" => "Dot\\Categories\\Controllers"
], function ($route) {
    $route->get("/categories/show", "CategoriesApiController@show");
    $route->get("/categories/samples", "CategoriesApiController@samples");
    $route->post("/categories/create", "CategoriesApiController@create");
    $route->post("/categories/update", "CategoriesApiController@update");
    $route->post("/categories/destroy", "CategoriesApiController@destroy");
});


