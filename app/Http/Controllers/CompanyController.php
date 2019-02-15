<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Chance;
use App\Models\Companies_empolyees;
use App\Models\Company;
use App\Models\Tender;
use App\User;
use Dot\Chances\Models\Sector;
use Dot\Media\Models\Media;
use Dot\Services\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function show(Request $request, $slug)
    {
        $company = Company::where('slug', '=', $slug)->firstOrFail();
        $this->data['sectors'] = Sector::published()->get();

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
        $this->data['chances_offer_count'] = $company->chances()->sum('offers');
        $this->data['chances_downloads_count'] = $company->chances()->sum('downloads');
        $this->data['status'] = [0, 1, 2, 3, 4, 5];

        return view('companies.chances', $this->data);
    }

    /**
     * GET {lang}/company/{id}/centers
     * @route company.centers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function centers(Request $request, $id)
    {

        $query = Center::published()->where('company_id', (int)$id);
        $this->data['selected_sector'] = null;
        $this->data['selected_service'] = null;
        $this->data['q'] = null;
        $this->data['company'] = Company::findOrFail($id);

        if ($request->get("selected_sector")) {
            $query = $query->where('sector_id', $request->get('selected_sector'));
            $this->data['selected_sector'] = $request->get("selected_sector");
        }
        if ($request->get('selected_service')) {
            $query = $query->whereHas('services', function ($query) use ($request) {
                $query->where('id', $request->get('selected_service'));
            });
            $this->data['selected_service'] = $request->get("selected_service");
        }
        if ($request->get('q')) {
            $q = trim(urldecode($request->get('q')));
            $query = $query->where('name', 'like', '%' . $q . '%');
            $this->data['q'] = $q;
        }
        if ($request->get('price_to')) {
            $to = $request->get('price_to');
            $from = $request->get('price_from', 100);

        }
        $this->data['centers'] = $query->paginate(2);
        $this->data['services'] = Service::published()->get();
        $this->data['sectors'] = Sector::published()->get();

        return view('companies.centers', $this->data);
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
        $employess = $name ? $employess->
        where('last_name', 'like', '%' . $name . '%')
            ->orWhere('first_name', 'like', '%' . $name . '%')
            ->orWhere('username', 'like', '%' . $name . '%') : $employess;
        $employess = $email ? $employess->where('email', $email) : $employess;
        $employess = $employess->get();

        $this->data['company'] = $company = Company::findOrFail($id);
        //Employees has been sent invitations before
        $sent_requests = $company->srequests()->pluck('id')->toArray();
        foreach ($employess as $key => $employer) {
            if (in_array($employer->id, $sent_requests))
                $employess->forget($key);
        }
        //Existing employees
        $current_emp = Companies_empolyees::where('company_id', '=', $id)->pluck('employee_id')->toArray();
        foreach ($employess as $key => $employer) {
            if (!in_array($employer->id, $current_emp)) {
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
            Companies_empolyees::where([
                ['company_id', $employee['company_id']],
                ['employee_id', $employee['employee_id']],
            ])->delete();
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
            Companies_empolyees::where([
                ['company_id', $employee['company_id']],
                ['employee_id', $employee['employee_id']],
            ])->delete();
            Companies_empolyees::create($employee);
            $company->srequests()->syncWithoutDetaching($employee['employee_id']);
        }
        return response()->json(['success' => true]);
    }

    /**
     * GET/POST {lang}/company/{id}/requests
     * @route company.requests
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function requests(Request $request, $id)
    {
        $this->data['company_id'] = $id;
        if ($request->method() == 'POST') {
            $users = $request->get('accepted', []);
            foreach ($users as $user_id) {
                var_dump($id);
                $is_employeed = Companies_empolyees::where([
                    ['employee_id', $user_id],
                    ['accepted', 1]
                ])->get();
                if (count($is_employeed) > 0)
                    continue;
                Companies_empolyees::where('employee_id', $user_id)->delete();
                Companies_empolyees::create([
                    'company_id' => $id,
                    'employee_id' => $user_id,
                    'role' => 0,
                    'status' => 0,
                    'accepted' => 1
                ]);
                DB::table('users_requests')->where('sender_id', $user_id)->delete();
            }
            $users = $request->get('rejected', []);
            foreach ($users as $user_id) {
                DB::table('users_requests')->where([
                    ['sender_id', $user_id],
                    ['receiver_id', $id]
                ])->delete();
            }
            return redirect()->route('company.requests', ['id' => $id])->with('status', trans('app.accepted_successfully'));
        } else {
            $this->data['requests'] = $requests = Company::findOrFail($id)->rrequests()->paginate(5);
            return view('companies.requests', $this->data);
        }
    }

    /**
     * GET/POST {lang}/company/{id}/employees
     * @route company.requests
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employees(Request $request, $id)
    {
        $this->data['name'] = $name = $request->get('name', null);
        $this->data['email'] = $email = $request->get('email', null);
        if ($request->method() == 'POST') {
            $employees = $request->get('employees');
            foreach ($employees as $employee) {
                Companies_empolyees::where([
                    ['company_id', $employee['company_id']],
                    ['employee_id', $employee['employee_id']],
                    ['accepted', 1]
                ])->update([
                    'status' => $employee['status'],
                    'role' => $employee['role']
                ]);
            }
            return response()->json(['success' => true]);
        } else {
            $this->data['company'] = $company = Company::findOrFail($id);
            $employees = Companies_empolyees::where([
                ['accepted', 1],
                ['company_id', $id]
            ]);
            $employees = $name ? $employees->whereHas('user', function ($query) use ($name) {
                $query->where('last_name', 'like', '%' . $name . '%')
                    ->orWhere('first_name', 'like', '%' . $name . '%')
                    ->orWhere('username', 'like', '%' . $name . '%');
            }) : $employees;
            $employees = $email ? $employees->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            }) : $employees;
            $this->data['employees'] = $employees->paginate(5);

            return view('companies.employees', $this->data);
        }

    }


    /**
     * POST {lang?}/mycompany/update
     * @route company.updates
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function companyUpdate(Request $request)
    {
        if (!fauth()->user()->is_owner) {
            return redirect()->back()->with(['messages' => [trans('app.cannot_update_company')]]);

        }

        $company = fauth()->user()->company[0];
        if (!$company) {
            return redirect()->back()->with(['messages' => [trans('app.cannot_update_company')]]);
        }

        $rules = [
            'name' => 'required|max:255|min:2',
            'sector_id' => 'required|exists:sectors,id',
            'details' => 'required|max:255',
            'address' => 'required|max:255',
            'logo' => 'required|mimes:jpg,png,jpeg',
            'files.*.mimes' => 'jpg,png,jpeg,doc,docx,txt,pdf,zip'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $company->name = $request->get('name');
        $company->details = $request->get('details');
        $company->address = $request->get('address');
        $company->sector_id = $request->get('sector_id');
        $company->phone_number = $request->get('phone_number');
        $company->mobile_number = $request->get('mobile_number');

        if ($request->hasFile('logo')) {
            $media = new Media();
            $company->image_id = $media->saveFile($request->file('logo'));
        }

        $company->save();
        $files = array();
        if ($request->file('files')) {
            foreach (($request->file('files')) as $file) {
                $media = new Media();
                $files[] = $media->saveFile($file);
            }
        }
        $company->files()->attach($files);

        return redirect()->back()->with('message', trans('app.profile_updated'));
    }

    /**
     * GET /{lang?}/company/{id}/tenders
     * @route company.tenders
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tenders(Request $request, $id)
    {
        $query = Tender::with(['org', 'org.logo'])->whereHas('transactions', function ($query) use ($id){
            $query->where('company_id', $id);
        })->published();

        if ($request->filled('activity_id')) {
            $query->where('activity_id', $request->get('activity_id'));
        }

        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . trim($request->get('q')) . '%');
        }

        if ($request->filled('org_id')) {
            $query->where('org_id', $request->get('org_id'));
        }

        if ($request->filled('number')) {
            $query->where('number', $request->get('number'));
        }
        if ($request->filled('offer_expired')) {
            $carbon = new Carbon($request->get('offer_expired'));
            $query->whereDay('last_get_offer_at', '<=', $carbon->day);
            $query->whereMonth('last_get_offer_at', '<=', $carbon->month);
            $query->whereYear('last_get_offer_at', '<=', $carbon->year);
        }


        if ($request->filled('place_id')) {
            $query->whereHas('places', function ($query) use ($request) {
                return $query->where('id', $request->get('place_id'));
            });
        }


        $this->data['tenders'] = $query->orderBy('created_at', 'DESC')->paginate(5);
        $this->data['company'] = Company::find($id);

        return view('companies.tenders', $this->data);
    }
}
