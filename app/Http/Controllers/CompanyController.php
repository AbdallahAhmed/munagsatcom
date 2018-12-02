<?php

namespace App\Http\Controllers;

use App\Models\Chance;
use App\Models\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public $data = array();

    public function show(Request $request, $id){
        $company = Company::findOrFail($id);
        $this->data['company'] = $company;

        return view('companies.company', $this->data);
    }

    public function chances(Request $request, $id){
        $company = Company::findOrFail($id);
        $this->data['company'] = $company;
        $this->data['q'] = $q = null;
        $this->data['created_at'] = null;
        $status = $request->get('status');
        $status = $status ? $status : [];
        $chances = Chance::query();
        $this->data['chosen_status'] = $status;

        foreach ($status as $st) {
            switch ($st) {
                case 0:
                    $chances = $chances->orWhere(function ($q) {
                        $q->opened();
                    });
                    break;
                case 1:
                    $chances = $chances->orWhere(function ($q) {
                        $q->closed();
                    });
                    break;
                case 2:
                    $chances = $chances->orWhere(function ($q) {
                        $q->cancelled();
                    });
                    break;
                case 3:
                    $chances = $chances->orWhere(function ($q) {
                        $q->pending();
                    });
                    break;
                case 4:
                    $chances = $chances->orWhere(function ($q) {
                        $q->approved();
                    });
                    break;
                case 5:
                    $chances = $chances->orWhere(function ($q) {
                        $q->rejected();
                    });
                    break;
            }
        }
        if ($request->get('q')) {
            $q = trim(urldecode($request->get('q')));
            $chances = $chances->where('name', 'like', '%' . $q . '%');
            $this->data['q'] = $q;
        }
        if ($request->get('created_at')) {
            $chances = $chances->whereDate('created_at', '=', \Carbon\Carbon::parse($request->get('created_at'))->toDateString());
            $this->data['created_at'] = $request->get('created_at');
        }
        $chances = count($status) > 0 || $q || $request->get('created_at') ? $chances->get() : $company->chances;
        $this->data['chances'] = $chances;
        $this->data['status'] = [0,1,2,3,4,5];

        return view('companies.chances', $this->data);
    }

    public function updatePassword(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        if(!(Hash::check($request->get('current_password'), fauth()->user()->password)))
            return redirect()->back()->withErrors(['wrong_current' => trans('validation.wrong_current')])->withInput($request->all());
        $user = User::where('email', fauth()->user()->email)->first();
        $user->password = $request->get('password');
        $user->save();
        return redirect()->route('company.show', ['id' => $id])->with('status', trans('app.events.password_changed'));

    }

}
