<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public $data = array();
    public function show(Request $request, $id){
        return view('companies.company', $this->data);
    }
}
