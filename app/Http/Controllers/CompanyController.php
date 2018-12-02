<?php

namespace App\Http\Controllers;

use Dot\Companies\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    public $data = array();
    public function show(Request $request, $id){
        $company = Company::findOrFail($id);
        $this->data['company'] = $company;

        return view('companies.company', $this->data);
    }
}
