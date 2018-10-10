<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:blocks.manage"],
    "namespace" => "Dot\\Chances\\Controllers"
], function ($route) {
    $route->group(["prefix" => "blocks"], function ($route) {
        $route->any('/', ["as" => "admin.blocks.show", "uses" => "ChancesController@index"]);
        $route->any('/create', ["as" => "admin.blocks.create", "uses" => "ChancesController@create"]);
        $route->any('/{block_id}/edit', ["as" => "admin.blocks.edit", "uses" => "ChancesController@edit"]);
        $route->any('/delete', ["as" => "admin.blocks.delete", "uses" => "ChancesController@delete"]);
        $route->any('/search', ["as" => "admin.blocks.search", "uses" => "ChancesController@search"]);
    });
});
