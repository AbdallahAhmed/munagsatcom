<?php

/*
 * WEB
 */

Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth:backend"],
    "namespace" => "Dot\\Media\\Controllers"
], function ($route) {
    $route->group(["prefix" => "media"], function ($route) {
        $route->any('/get/{offset?}/{type?}/{q?}', ["as" => "admin.media.index", "uses" => "MediaController@index"]);
        $route->any('/save_gallery', ["as" => "admin.media.save_gallery", "uses" => "MediaController@save_gallery"]);
        $route->any('/save', ["as" => "admin.media.save", "uses" => "MediaController@save"]);
        $route->any('/delete', ["as" => "admin.media.delete", "uses" => "MediaController@delete"]);
        $route->any('/upload', ["as" => "admin.media.upload", "uses" => "MediaController@upload"]);
        $route->any('/download', ["as" => "admin.media.download", "uses" => "MediaController@download"]);
        $route->any('/link', ["as" => "admin.media.link", "uses" => "MediaController@link"]);
        $route->any('/crop', ["as" => "admin.media.crop", "uses" => "MediaController@crop"]);
        $route->any('/watermark', ["as" => "admin.media.watermark", "uses" => "MediaController@watermark"]);
        $route->any('/galleries/create', ["as" => "admin.media.gallery_create", "uses" => "MediaController@gallery_create"]);
        $route->any('/galleries/delete', ["as" => "admin.media.gallery_delete", "uses" => "MediaController@gallery_delete"]);
        $route->any('/galleries/edit', ["as" => "admin.media.gallery_edit", "uses" => "MediaController@gallery_edit"]);
    });
});


/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"],
    "namespace" => "Dot\\Media\\Controllers"
], function ($route) {
    $route->get("/media/show", "MediaApiController@show");
    $route->post("/media/create", "MediaApiController@create");
    $route->post("/media/update", "MediaApiController@update");
    $route->post("/media/destroy", "MediaApiController@destroy");
});


