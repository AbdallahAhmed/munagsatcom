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

//Route::group(['prefix' => 'chances'],function ($route){
//    $route->get('/create', "ChanceController@create")->name("chance.create");
//    $route->post('/store', "ChanceController@store")->name("chance.store");
//    $route->post('/getUnits', "ChanceController@getUnits")->name("chance.units");
//});


Route::group(['prefix' => '/{lang?}', 'middleware' => ['localization']], function () {

    Route::any('register', 'UserController@register')->name('register');
    Route::any('login', 'UserController@login')->name('login');

    Route::get('centers', 'CenterController@index')->name('centers');
    Route::get('centers/{id}', 'CenterController@show')->name('centers.show');
    Route::post('centers/contact', 'CenterController@contact')->name('centers.contact');

    Route::get('chances', 'ChanceController@index')->name('chances');
    Route::get('chances/{id}', 'ChanceController@show')->name('chances.show');
    Route::post('chances/offers', 'ChanceController@addOffer')->name('chances.offers');


});