<?php

namespace App\Http\Controllers;

use App\Models\Chance;
use App\Models\Companies_empolyees;
use App\Models\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    /**
     * Data unit
     * @var array
     */
    public $data = array();

    /**
     * GET {lang}/company/{id}
     * @route company.show
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $this->data['company'] = $company;

        return view('companies.company', $this->data);
    }

    /**
     * GET {lang}/company/{id}/chances
     * @route company.chances
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chances(Request $request, $id)
    {
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
        $this->data['status'] = [0, 1, 2, 3, 4, 5];

        return view('companies.chances', $this->data);
    }

    /**
     * POST {lang}/company/{id}/password
     * @route company.password
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePassword(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        if (!(Hash::check($request->get('current_password'), fauth()->user()->password)))
            return redirect()->back()->withErrors(['wrong_current' => trans('validation.wrong_current')])->withInput($request->all());
        $user = User::where('email', fauth()->user()->email)->first();
        $user->password = $request->get('password');
        $user->save();
        return redirect()->route('company.show', ['id' => $id])->with('status', trans('app.events.password_changed'));

    }

    /**
     * GET {lang}/company/{id}/search
     * @route company.employees.search
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employerSearch(Request $request, $id)
    {
        $this->data['name'] = $name = $request->get('name', null);
        $this->data['email'] = $email = $request->get('email', null);

        $employess = User::where([
            //['type', '=', 1],
            ['status', '=', 1]
        ]);
        $employess = $name ? $employess->where('name', 'like', '%' . $name . '%') : $employess;
        $employess = $email ? $employess->where('email', $email) : $employess;
        $employess = $employess->get();

        $this->data['company'] = $company = Company::findOrFail($id);
        $sent_requests = $company->srequests()->pluck('id')->toArray();
        foreach ($employess as $key => $employer) {
            if (in_array($employer->id, $sent_requests))
                $employess->forget($key);

        }
        $current_emp = Companies_empolyees::where('company_id', '=', (int)$id)->pluck('employee_id')->toArray();
        foreach ($employess as $key => $employer) {

            if (in_array($employer->id, $current_emp)){
                $employess->forget($key);
            }
        }
        $ids = array();
        foreach ($employess as $emp)
            $ids[] = $emp->id;

        $employess = count($ids) > 0 ? User::whereIn('id', $ids)->paginate(5) : $employess;
        $this->data['employees'] = $employess;

        return view('companies.search_for_employees', $this->data);
    }

    /**
     * POST {lang}/company/{id}/addEmployees
     * @route company.employees.add
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addEmployees(Request $request, $id)
    {
        $employees = $request->get('employees');
        foreach ($employees as $employee) {
            Companies_empolyees::create($employee);
        }
        return response()->json(['success' => true]);
    }

    /**
     * POST {lang}/company/{id}/send
     * @route company.employees.send
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function send(Request $request, $id)
    {
        $employees = $request->get('employees');
        $company = Company::findOrFail($id);
        foreach ($employees as $employee) {
            Companies_empolyees::create($employee);
            $company->srequests()->syncWithoutDetaching($employee['employee_id']);
        }
        return response()->json(['success' => true]);
    }

}
