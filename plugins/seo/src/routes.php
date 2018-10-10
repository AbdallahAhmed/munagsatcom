<?php


Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend"],
    "namespace" => "Dot\\Seo\\Controllers"
], function ($route) {
    $route->get('google/keywords', ["as" => "admin.google.search", "uses" => "ServicesController@keywords"]);
});


Route::group([
    "middleware" => ["web"],
    "namespace" => "Dot\\Seo\\Controllers"
], function ($route) {
    $route->get('sitemap/update', ["as" => "sitemap.update", "uses" => 'ServicesController@sitemap']);
});




