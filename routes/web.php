<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("index");

Route::group(['prefix' => 'chances'],function ($route){
    $route->get('/create', "ChanceController@create")->name("chance.create");
    $route->post('/store', "ChanceController@store")->name("chance.store");
    $route->post('/getUnits', "ChanceController@getUnits")->name("chance.units");
});
