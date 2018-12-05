<?php

namespace App\Http\Controllers;

use App\Models\Companies_empolyees;
use App\User;
use Dot\Chances\Models\Sector;
use Dot\Companies\Models\Company;
use Dot\Media\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'first_name' => 'required',
                'last_name' => 'required',
            ];
            if ($request->get('user_type') == 2) {
                $rules += [
                    'company_name' => 'required|max:255|min:8',
                    'sector_id' => 'required|exists:sectors,id',
                    'details' => 'required|max:255',
                    'logo' => 'required|mimes:jpg,png,jpeg',
                    'files.*.mimes' => 'jpg,png,jpeg,doc,docx,txt,pdf,zip'
                ];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $user = new User();
            $user->username = $request->get('email');
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->password = ($request->get('password'));
            $user->role_id = 2;
            $user->backend = 0;
            $user->status = 0;
            $user->type = $request->get('user_type', 1);
            $user->save();
            if ($request->get('user_type') == 2) {
                $company = new Company();
                $company->name = $request->get('company_name');
                $company->details = $request->get('details');
                $company->first_name = $user->first_name;
                $company->last_name = $user->last_name;
                $company->user_id = $user->id;
                $company->sector_id = $request->get('sector_id');

                $media = new Media();
                $company->image_id = $media->saveFile($request->file('logo'));

                $files = array();
                foreach ($request->file('files') as $file) {
                    $media = new Media();
                    $files[] = $media->saveFile($file);
                }
                $company->save();
                Companies_empolyees::create([
                    'company_id' => $company->id,
                    'employee_id' => $user->id,
                    'role' => 1,
                    'status' => 1,
                    'accepted' => 1
                ]);
                $company->files()->sync($files);
            }

            return redirect()->route('login')->with('status', trans('app.events.successfully_register'));
            //return success or redirect
        }

        $this->data['sectors'] = Sector::published()->get();
        return view('register', $this->data);
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
                    'password' => 'required',
                    'user_type' => 'required'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput($request->all());
                }

                $isAuthed = fauth()->attempt([
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                    'backend' => 0
                ]);

                if (!$isAuthed) {
                    $error->add('invalid', trans('validation.invalid_login'));
                    return redirect()->back()->withErrors($error->messages())->withInput($request->all());
                }
                if (fauth()->user()->type == 2 && fauth()->user()->status == 0) {
                    fauth()->logout();
                    //$error->add('not verified', "This company isn't verified yes.");
                    return redirect()->back()->withErrors($validator)->withInput($request->all());
                }
                fauth()->login(fauth()->user());
                return redirect()->route('index');
            }
            return view('login');
        }
        return redirect()->route('index');
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
        return redirect()->route('user.show', ['user' => $user])->with('status', trans('app.events.password_changed'));
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

        $this->data['requests'] = $requests = User::find($id)->requests()->paginate(4);

        return view('users.requests', $this->data);
    }

    /**
     * post {lang}/user/requests/update
     * @route user.requests.update
     * @param Request $request
     * @return View
     */
    public function updateRequests(Request $request){
        $company = $request->get('accepted', null);
        if ($company){
            DB::table('companies_requests')->where([
                ['receiver_id', fauth()->user()->id],
                ['sender_id', $company]
            ])->delete();
            Companies_empolyees::where([
                ['company_id',$company],
                ['employee_id', fauth()->user()->id]
            ])->update(['accepted' => 1]);
            return redirect()->route('user.show')->with('status', 'ssss');
        }
    }
}
