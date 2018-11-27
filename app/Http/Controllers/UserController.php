<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    /**
     * GET {lang}/register
     * @route register
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        return view('register');
    }
}
