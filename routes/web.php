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


use App\Models\Notifications;

Route::group(['prefix' => '/{lang?}', 'middleware' => ['localization']], function () {

Route::get('/sss',function (){
   $not = Notifications::find(1);

});
    // tenders
    Route::get('/', 'TenderController@index')->name('index');
    Route::get('tenders/{slug}', 'TenderController@details')->name('tenders.details');


    Route::any('register', 'UserController@register')->name('register');
    Route::any('login', 'UserController@login')->name('login');
    Route::any('logout', 'UserController@logout')->name('flogout');
    Route::any('forgetpassword', 'UserController@forgetPassword')->name('forget-password');
    Route::any('reset', 'UserController@reset')->name('reset-password');
    Route::post('verify', 'UserController@verify')->name('user.verify');
    Route::get('verify/link', 'UserController@verifyLink')->name('user.verify.link');
    Route::get('verify', 'UserController@confirm')->name('user.confirm');
    Route::any('verify/resend', 'UserController@confirmResend')->name('user.confirm-resend');
    Route::group(['middleware' => ['fauth']], function () {

        //Notifications
        Route::post('notifications/live', 'NotificationController@getUnreadNotifications')->name('notifications.check');
        Route::get('/user/notifications', 'NotificationController@getUserNotifications')->name('user.notifications');
        Route::post('tenders/{id}/buycb', 'TenderController@buyCB')->name('tenders.buy');
        Route::get('tenders/{id}/download', 'TenderController@download')->name('tenders.download');
        Route::get('user/update', 'UserController@show')->name('user.show');
        Route::post('user/update', 'UserController@update')->name('user.update');
        Route::post('user/profile-update', 'UserController@profileUpdate')->name('user.profile.update');
        Route::get('user/search/companies', 'UserController@searchCompanies')->name('user.company.search');
        Route::get('user/points', 'UserController@points')->name('user.points');
        Route::get('user/requests', 'UserController@requests')->name('user.requests');
        Route::post('user/requests/update', 'UserController@updateRequests')->name('user.requests.update');
        Route::post('user/requests/send', 'UserController@sendRequests')->name('user.requests.send');
        Route::get('user/centers', 'UserController@centers')->name('user.centers');
        Route::get('user/recharge', 'PaymentsController@index')->name('user.recharge');
        Route::post('user/recharge', 'PaymentsController@recharge')->name('user.recharge');
        Route::get('user/checkout', 'PaymentsController@checkout')->name('user.checkout');
    });

    Route::get('centers', 'CenterController@index')->name('centers');
    Route::get('centers/{slug}', 'CenterController@show')->name('centers.show');
    Route::post('centers/contact', 'CenterController@contact')->name('centers.contact');

    Route::get('chances', 'ChanceController@index')->name('chances');
    Route::post('chances/offers', 'ChanceController@addOffer')->name('chances.offers');
    Route::get('chances/{slug}', 'ChanceController@show')->name('chances.show');
    Route::get('chances/{id}/download', 'ChanceController@download')->name('chances.download');
    Route::get('chances/{id}/cancel', 'CompanyController@chancesCancel')->name('chances.cancel');


    Route::group(['middleware' => ['company']], function ($router) {


        $router->post('mycompany/{id}/update', 'CompanyController@companyUpdate')->name('company.updates');
        $router->get('company/{slug}', 'CompanyController@show')->name('company.show');
        $router->get('company/{id}/chances', 'CompanyController@chances')->name('company.chances');
        $router->get('company/{id}/centers', 'CompanyController@centers')->name('company.centers');
        $router->get('company/{id}/tenders', 'CompanyController@tenders')->name('company.tenders');
        $router->any('company/{id}/employees', 'CompanyController@employees')->name('company.employees');
        $router->any('company/{id}/requests', 'CompanyController@requests')->name('company.requests');
        $router->get('company/{id}/search', 'CompanyController@employerSearch')->name('company.employees.search');
        $router->get('company/{id}/addEmployees', 'CompanyController@addEmployees')->name('company.employees.add');
        $router->post('company/{id}/addEmployees', 'CompanyController@addEmployees')->name('company.employees.add');
        $router->post('company/{id}/send', 'CompanyController@send')->name('company.employees.send');
        $router->get('company/{id}/delegate', 'CompanyController@show')->name('company.add_delegate');
        $router->get('company/{id}/messages', 'CompanyController@show')->name('company.messages');
        $router->post('company/{id}/password', 'CompanyController@updatePassword')->name('company.password');
        $router->any('company/{id}/chance/create', 'ChanceController@store')->name('chances.create');
        $router->any('company/{id}/chance/{chance_id}/update', 'ChanceController@update')->name('chances.update');
        $router->any('company/{id}/center/create', 'CenterController@store')->name('centers.create');
        $router->any('company/{id}/center/{center_id}/update', 'CenterController@update')->name('centers.update');
        $router->get('company/{id}/chances/{chance_id}/offers', 'ChanceController@showOffer')->name('chances.offers.show');
        $router->post('company/{id}/chances/approveOffers', 'ChanceController@approveOffers')->name('chances.offers.approve');
    });

    Route::get('page/{slug}', 'PageController@show')->name('page.show');
    Route::any('contact-us', 'PageController@contactUs')->name('contact-us');

});
