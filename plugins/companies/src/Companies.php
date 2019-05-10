<?php

namespace Dot\Companies;

use App\Models\Transaction;
use Dot\Platform\Classes\Carbon;
use Illuminate\Support\Facades\Auth;
use Navigation;
use URL;

use Dot\Platform\Facades\Action;

class Companies extends \Dot\Platform\Plugin
{

    protected $permissions = [
        "manage",
        "transactions"
    ];

    function boot()
    {

        parent::boot();

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("companies.manage")) {
                $menu->item('companies', trans("companies::companies.companies"), route("admin.companies.show"))->icon("fa-folder")->order(1);
            }
        });

        Navigation::menu("sidebar", function ($menu) {

            if (Auth::user()->can("companies.transactions")) {
                $menu->item('transactions', trans("companies::companies.transactions"), route("admin.companies.transactions"))->icon("fa-money")->order(2);
            }
        });

        Action::listen("dashboard.featured", function () {
            $data = [];
            $now = Carbon::now();
            $data['dates'] = [];
            $data['spent_points'] = [];
            $data['add_points'] = [];
            for ($index = 0; $index <= 30; $index++) {

                $data['dates'] [] = $now->subDay()->format('Y/m/d');
                $data['spent_points'][] = Transaction::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $now->month)
                    ->whereDay('created_at', $now->day)
                    ->where('action', '<>', 'points.buy')
                    ->sum('points');
                $data['add_points'][] = Transaction::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $now->month)
                    ->whereDay('created_at', $now->day)
                    ->where('action', 'points.buy')
                    ->sum('points');
            }
            $data['dates'] = array_reverse($data['dates']);
            $data['spent_points'] = array_reverse($data['spent_points']);
            $data['add_points'] = array_reverse($data['add_points']);
//dd($data);
            return view('companies::widget', $data);
        });

    }
}
