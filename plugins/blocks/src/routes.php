<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:blocks.manage"],
    "namespace" => "Dot\\Blocks\\Controllers"
], function ($route) {
    $route->group(["prefix" => "blocks"], function ($route) {
        $route->any('/', ["as" => "admin.blocks.show", "uses" => "BlocksController@index"]);
        $route->any('/create', ["as" => "admin.blocks.create", "uses" => "BlocksController@create"]);
        $route->any('/{block_id}/edit', ["as" => "admin.blocks.edit", "uses" => "BlocksController@edit"]);
        $route->any('/delete', ["as" => "admin.blocks.delete", "uses" => "BlocksController@delete"]);
        $route->any('/search', ["as" => "admin.blocks.search", "uses" => "BlocksController@search"]);
    });
});
