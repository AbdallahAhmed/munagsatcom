<?php

Route::group([
    "middleware" => ["web"],
    "namespace" => "Dot\\I18n\\Controllers"
], function ($route) {
    $route->get('{lang}/locale', ['uses' => 'LocalesController@index', 'as' => 'admin.languages']);
    $route->get('locale', ['uses' => 'LocalesController@index', 'as' => 'admin.languages']);
});

/*
 * WEB
 */


Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend", "can:i18n.manage_places"],
    "namespace" => "Dot\\I18n\\Controllers"
], function ($route) {
    $route->group(["prefix" => "places"], function ($route) {
        $route->any('/create/{parent?}', ["as" => "admin.places.create", "uses" => "PlacesController@create"]);
        $route->any('/{place_id}/edit/{parent?}', ["as" => "admin.places.edit", "uses" => "PlacesController@edit"]);
        $route->any('/delete', ["as" => "admin.places.delete", "uses" => "PlacesController@delete"]);
        $route->any('/{status}/status', ["as" => "admin.places.status", "uses" => "PlacesController@status"]);
        $route->any('/search', ["as" => "admin.places.search", "uses" => "PlacesController@search"]);
        $route->any('/{parent?}', ["as" => "admin.places.show", "uses" => "PlacesController@index"]);
    });
});

