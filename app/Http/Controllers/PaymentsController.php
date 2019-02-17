<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    /**
     * GET {lang?}/user/recharge/
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        return view('payments');
    }
}
