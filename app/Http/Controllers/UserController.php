<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Mail\VerificationMail;
use App\Mail\WelcomeMail;
use App\Models\Center;
use App\Models\Companies_empolyees;
use App\Models\Transaction;
use App\User;
use Carbon\Carbon;
use Dot\Chances\Models\Sector;
use Dot\Companies\Models\Company;
use Dot\Media\Models\Media;
use Dot\Services\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Data unit
     * @var array
     */
    public $data = array();

    /**
     * GET/POST {lang}/register
     * @route register
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {

        if ($request->method() == 'POST') {
            $rules = [
                'name' => 'required|min:8',
//                'last_name' => 'required|alpha|min:3',
                'email' => 'required|email|unique:users',
//                'phone_number' => 'min:10',
                'password' => 'required|confirmed|min:6|max:255',
            ];
            if ($request->get('user_type') == 2) {
                $rules += [
                    'company_name' => 'required|max:255|min:2',
                    'sector_id' => 'required|exists:sectors,id',
//                    'details' => 'required|max:255',
//                    'logo' => 'required|mimes:jpg,png,jpeg',
                    'files.*.mimes' => 'jpg,png,jpeg,doc,docx,txt,pdf,zip'
                ];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $failed = $validator->failed();
                if (isset($failed['email']['Unique'])) {
                    $user = User::where('email', $request->get('email'))->first();
                    if ($user->status == 1 && $user->code != null) {
                        $validator = Validator::make($request->all(), $rules, ['email.unique' => trans('validation.email.unique')]);
                    }
                }
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            $user = new User();
            $user->username = $request->get('email');
            $names = explode(' ', $request->get('name'));
            $user->first_name = isset($names[0]) ? $names[0] : '';
            $user->last_name = isset($names[1]) ? $names[1] : '';
            $user->email = $request->get('email');
            $user->phone_number = $request->get('phone_number', '');
            $user->password = ($request->get('password'));
            $user->role_id = 2;
            $user->backend = 0;
            $user->status = 0;
            $user->points = option('new_user_points', 0);
            $user->code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            $user->type = $request->get('user_type', 1);

//            if ($request->file('logo')) {
//                $media = new Media();
//                $user->photo_id = $media->saveFile($request->file('logo'));
//            }
            $user->save();
            if ($request->get('user_type') == 2) {
                $company = new Company();
                $company->name = $request->get('company_name');
                $company->details = $request->get('details');
                $company->first_name = $user->first_name;
                $company->last_name = $user->last_name;
                $company->user_id = $user->id;
                $company->address = $request->get('address');
                $company->sector_id = $request->get('sector_id');
                $company->phone_number = $request->get('phone_number');
                $company->mobile_number = $request->get('mobile_number');
                $company->points = option('new_user_points', 0);

//                $media = new Media();
//                $company->image_id = $media->saveFile($request->file('logo'));

//                $files = array();
//                if ($request->file('files')) {
//                    foreach (($request->file('files')) as $file) {
//                        $media = new Media();
//                        $files[] = $media->saveFile($file);
//                    }
//                }
                $company->save();
                Companies_empolyees::create([
                    'company_id' => $company->id,
                    'employee_id' => $user->id,
                    'role' => 1,
                    'status' => 1,
                    'accepted' => 1
                ]);
//                $company->files()->sync($files);
            }
            session()->put('email', $user->email);
            try {
                Mail::to($user->email)->send(new VerificationMail($user));
            } catch (\Exception $e) {

            }
            return redirect()->route('user.confirm')->with('status', trans('app.check_email'));
//            return redirect()->route('index')->with(['messages' => [trans('app.events.successfully_register_company')], 'status' => 'success']);
            //return success or redirect
        }

        $this->data['sectors'] = Sector::published()->get();
        return view('register', $this->data);
    }

    /**
     * POST {lang?}/user/profile-update
     * @route user.profile.update
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profileUpdate(Request $request)
    {
        $rules = [
            'first_name' => 'required|alpha|min:3',
            'last_name' => 'required|alpha|min:3',
            'phone_number' => 'min:10',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $user = fauth()->user();
        if ($request->file('logo')) {
            $media = new Media();
            $user->photo_id = $media->saveFile($request->file('logo'));
        }
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->phone_number = $request->get('phone_number');

        $user->save();
        return redirect()->back()->with('message', trans('app.profile_updated'));
    }

    /**
     * GET/POST {lang}/login
     * @route login
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {

        if (!fauth()->check()) {
            if ($request->method() == "POST") {
                $error = new MessageBag();
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required']);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput($request->all());
                }

                if (!fauth()->attempt([
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                    'backend' => 0,
                    'status' => 1
                ])) {

                    $error->add('invalid', trans('validation.invalid_login'));
                    return redirect()->back()->withErrors($error->messages())->withInput($request->all());
                }

                if (fauth()->user()->type == 2 && fauth()->user()->status == 0) {
                    fauth()->logout();
                    return redirect()->back()->withErrors(new MessageBag(['not_verified' => trans('app.company_not_verified')]));
                }

                if (!empty(fauth()->user()->company[0]) &&
                    fauth()->user()->company[0]->pivot->status == 0) {
                    fauth()->logout();
                    return redirect()->back()->withErrors(new MessageBag(['not_verified' => trans('app.your_account_deactivate')]));
                }
                fauth()->login(fauth()->user());
                return redirect()->route('index');
            }
            return view('login');
        }
        return redirect()->route('index');
    }

    /**
     * POST {lang}/logout
     * @route login
     * @param Request $request
     * @return string
     */
    public function logout()
    {
        Auth::guard('frontend')->logout();
        return redirect()->route('index');
    }

    /**
     * POST {lang}/verify
     * @route user.verify
     * @param Request $request
     * @return string
     */
    public function verify(Request $request)
    {

        $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            if ($user->code == $request->get('code')) {
                $user->code = null;
                $user->status = 1;
                $user->save();
                if ($user->type == 1) {
                    fauth()->login($user);
                    return redirect()->route('index');
                }
                return redirect()->back()->with('waiting', trans('app.company_waiting'));
            } else
                return redirect()->back()->withErrors(['wrong_code' => trans('app.wrong_code')]);
        } else {
            return redirect()->back()->withErrors(['wrong_email' => trans('app.email_not_found')]);
        }
    }


    /**
     * GET {lang}/verify/link
     * @route user.verify.link
     * @param Request $request
     * @return string
     */
    public function verifyLink(Request $request)
    {


        $user = User::where('email', \Crypt::decryptString(urldecode($request->get('key'))))->first();
        if ($user) {
            if ($user->code == $request->get('code')) {
                $user->code = null;
                $user->status = 1;
                $user->save();
                if ($user->type == 1) {
                    fauth()->login($user);
                    return redirect()->route('index')->with(['messages' => [trans('app.account_activated')], 'status' => 'success']);
                }
                return redirect()->back()->with('waiting', trans('app.company_waiting'));
            } else
                return redirect()->back()->withErrors(['wrong_code' => trans('app.wrong_code')]);
        } else {
            return redirect()->back()->withErrors(['wrong_email' => trans('app.email_not_found')]);
        }
    }

    /**
     * GET {lang}/verify
     * @route user.confirm
     * @param Request $request
     * @return string
     */
    public function confirm(Request $request)
    {
        if (session()->get('email')) {
            return view('confirm', ['email' => session()->get('email')]);
        }
        return redirect()->route('index');

    }

    /**
     * POST/GET {lang}/verify/resend
     * @route user.confirm-resend
     * @param Request $request
     * @return string
     */
    public function confirmResend(Request $request)
    {
        session()->remove('status');
        if ($request->method() == 'GET') {
            return view('confirm-resend');
        } else
            $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            $user->code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            $user->save();
            session()->put('email', $request->get('email'));
            Mail::to($user->email)->send(new VerificationMail($user));
            return redirect()->route('user.confirm')->with('status', trans('app.check_email'));
        } else
            return redirect()->route('user.confirm-resend')->withErrors(new MessageBag(['wrong_email' => trans('app.email_not_found')]));
    }

    /**
     * POST/GET {lang}/forgetPassword
     * @route forget-password
     * @param Request $request
     * @return string
     */
    public function forgetPassword(Request $request)
    {
        if ($request->method() == 'POST') {
            $user = User::where([
                ['email', $request->get('email')],
                ['backend', 0]
            ])->first();
            if (!$user)
                return redirect()->back()->withErrors(new MessageBag(['wrong_email' => trans('app.email_not_found')]));
            $user->code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
            $user->save();
            Mail::to($user->email)->send(new ResetPasswordMail($user));
            return redirect()->route('reset-password');
        }
        return view('forgetpassword');
    }

    /**
     * POST/GET {lang}/forgetPassword
     * @route forget-password
     * @param Request $request
     * @return string
     */
    public function reset(Request $request)
    {
        if ($request->method() == 'POST') {
            $user = User::where('email', $request->get('email', ""))->first();
            if (!$user)
                return redirect()->back()->withErrors(new MessageBag(['wrong_email' => trans('app.email_not_found')]));
            $validator = Validator::make($request->all(), [
                'code' => 'required',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            if ($user->code != $request->get('code')){
                return redirect()->back()->withErrors(new MessageBag(['wrong_conde' => trans('app.wrong_code')]));

            }
            $user->code = null;
            $user->password = $request->get('password');
            $user->save();

            $isAuthed = fauth()->attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'backend' => 0
            ]);

            if ($isAuthed) {
                return redirect()->route('index');
            }
            return redirect()->back()->with('status', trans('app.password_changed'));
        }
        return view('reset');
    }

    /**
     * GET {lang}/user/update
     * @route user.show
     * @param Request $request
     * @return View
     */
    public function show()
    {
        return view('users.profile', ['user' => fauth()->user()]);
    }

    /**
     * POST {lang}/user/update
     * @route user.update
     * @param Request $request
     * @return string
     */
    public function update(Request $request)
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
        return redirect()->route('user.show')->with('status', trans('app.events.password_changed'));
    }

    /**
     * GET {lang}/user/requests
     * @route user.requests
     * @param Request $request
     * @return View
     */
    public function requests(Request $request)
    {
        $id = fauth()->user()->id;
        $this->data['is_employee'] = false;
        if (count(Companies_empolyees::where('employee_id', $id)->get()) > 0)
            $this->data['is_employee'] = true;

        $this->data['requests'] = $requests = User::find($id)->rrequests()->paginate(5);

        return view('users.requests', $this->data);
    }

    /**
     * POST {lang}/user/requests/update
     * @route user.requests.update
     * @param Request $request
     * @return Route
     */
    public function updateRequests(Request $request)
    {
        $company = $request->get('accepted', null);
        if ($company) {
            DB::table('companies_requests')->where([
                ['receiver_id', fauth()->user()->id],
                ['sender_id', $company]
            ])->delete();
            Companies_empolyees::where([
                ['company_id', $company],
                ['employee_id', fauth()->user()->id]
            ])->update(['accepted' => 1]);
            return redirect()->route('user.requests')->with('status', trans('app.saved_successfully'));
        }
    }

    /**
     * GET {lang}/user/search/companies
     * @route user.company.search
     * @param Request $request
     * @return View
     */
    public function searchCompanies(Request $request)
    {
        $id = fauth()->user()->id;
        $this->data['companies'] = null;
        if (count(Companies_empolyees::where([['employee_id', $id], ['accepted', 1], ['status', 1]])->get()) == 0) {
            $this->data['q'] = $q = $request->get('q', null);
            $sent_requests = fauth()->user()->requests()->pluck('id')->toArray();
            $query = Company::query();
            $query = count($sent_requests) > 0 ? $query->whereNotIn('id', $sent_requests) : $query;
            $query = $q != null ? $query->where('name', '%' . $q . '%') : $query;
            $this->data['companies'] = $query->paginate(5);

            return view('users.search', $this->data);
        }
        return view('users.search', $this->data);
    }

    /**
     * post {lang}/user/requests/send
     * @route user.requests.send
     * @param Request $request
     * @return Route
     */
    public function sendRequests(Request $request)
    {
        fauth()->user()->requests()->syncWithoutDetaching($request->get('companies', []));
        return redirect()->route('user.company.search')->with('status', trans('app.requests_sent_successfully'));
    }

    /**
     * GET {lang}/centers
     * @route user.centers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function centers(Request $request)
    {

        $query = Center::where('user_id', fauth()->user()->id);
        $this->data['sector_id'] = null;
        $this->data['service_id'] = null;
        $this->data['q'] = null;

        if ($request->get("sector_id")) {
            $query = $query->where('sector_id', $request->get('sector_id'));
            $this->data['sector_id'] = $request->get("sector_id");
        }
        if ($request->get('service_id')) {
            $query = $query->whereHas('services', function ($query) use ($request) {
                $query->where('id', $request->get('service_id'));
            });
            $this->data['service_id'] = $request->get("service_id");
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
        $this->data['centers'] = $query->paginate(5);
        $this->data['services'] = Service::published()->get();
        $this->data['sectors'] = Sector::published()->get();

        return view('users.centers', $this->data);
    }

    /**
     * GET {lang?}/user/points
     * @route user.points
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function points(Request $request)
    {
        $this->data['user'] = fauth()->user();
        $this->data['transactions'] = Transaction::with('tender')->where('user_id', $this->data['user']->id)
            ->whereMonth('created_at', $request->get('month', Carbon::now()->month - 1) + 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('users.points', $this->data);
    }
}
