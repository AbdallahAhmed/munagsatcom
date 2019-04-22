<?php

namespace App\Providers;

use App\Models\Notifications;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once app_path('helper.php');
        Schema::defaultStringLength(250);

        if (fauth()->check()) {
            view()->composer('layouts.partials.header', function ($view) {
                ($notifications = Notifications::where('user_id', fauth()->id)->get());
                $view->with('notifications', $notifications);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
