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

//Route::get('/', function () {
//    return view('welcome');
//})->name("index");

//Route::group(['prefix' => 'chances'],function ($route){
//    $route->get('/create', "ChanceController@create")->name("chance.create");
//    $route->post('/store', "ChanceController@store")->name("chance.store");
//    $route->post('/getUnits', "ChanceController@getUnits")->name("chance.units");
//});


Route::group(['prefix' => '/{lang?}', 'middleware' => ['localization']], function () {


    Route::get('/','TenderController@index')->name('index');
    Route::any('register', 'UserController@register')->name('register');
    Route::any('login', 'UserController@login')->name('login');
    Route::any('logout', 'UserController@logout')->name('flogout');
    Route::any('forgetpassword', 'UserController@forgetPassword')->name('forget-password');
    Route::any('reset', 'UserController@reset')->name('reset-password');
    Route::group(['middleware' => ['fauth']], function () {
        Route::get('user/update', 'UserController@show')->name('user.show');
        Route::post('user/update', 'UserController@update')->name('user.update');
        Route::get('user/search/companies', 'UserController@searchCompanies')->name('user.company.search');
        Route::get('user/requests', 'UserController@requests')->name('user.requests');
        Route::post('user/requests/update', 'UserController@updateRequests')->name('user.requests.update');
        Route::post('user/requests/send', 'UserController@sendRequests')->name('user.requests.send');
    });

    Route::get('centers', 'CenterController@index')->name('centers');
    Route::get('centers/{id}', 'CenterController@show')->name('centers.show');
    Route::post('centers/contact', 'CenterController@contact')->name('centers.contact');

    Route::get('chances', 'ChanceController@index')->name('chances');
    Route::get('chances/{id}', 'ChanceController@show')->name('chances.show');
    Route::post('chances/offers', 'ChanceController@addOffer')->name('chances.offers');


    Route::group(['middleware' => ['company']], function ($router){
        $router->get('company/{id}', 'CompanyController@show')->name('company.show');
        $router->get('company/{id}/chances', 'CompanyController@chances')->name('company.chances');
        $router->get('company/{id}/tenders', 'CompanyController@show')->name('company.tenders');
        $router->any('company/{id}/employees', 'CompanyController@employees')->name('company.employees');
        $router->get('company/{id}/centers', 'CompanyController@show')->name('company.centers');
        $router->any('company/{id}/requests', 'CompanyController@requests')->name('company.requests');
        $router->get('company/{id}/search', 'CompanyController@employerSearch')->name('company.employees.search');
        $router->post('company/{id}/addEmployees', 'CompanyController@addEmployees')->name('company.employees.add');
        $router->post('company/{id}/send', 'CompanyController@send')->name('company.employees.send');
        $router->get('company/{id}/delegate', 'CompanyController@show')->name('company.add_delegate');
        $router->get('company/{id}/messages', 'CompanyController@show')->name('company.messages');
        $router->post('company/{id}/password', 'CompanyController@updatePassword')->name('company.password');
    });


});