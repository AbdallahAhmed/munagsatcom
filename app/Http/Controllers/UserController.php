<?php

namespace App\Http\Controllers;

use App\User;
use Dot\Chances\Models\Sector;
use Dot\Companies\Models\Company;
use Dot\Media\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Data unit
     * @var array
     */
    public $data = array();
    /**
     * GET {lang}/register
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
                'name' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ];
            if ($request->get('user_type') == 2) {
                $rules += [
                    'sector_id' => 'required',
                    'details' => 'max:255',
                    'logo' => 'mimes:jpg,png,jpeg',
                    'files.*.mimes' => 'jpg,png,jpeg,doc,docx,txt,pdf,zip'
                ];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                dd($validator->errors()->all());
            }

            $user = new User();
            $user->username = $request->get('name');
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->password = ($request->get('password'));
            $user->role_id = 2;
            $user->backend = 0;
            $user->status = 0;
            $user->save();
            if ($request->get('user_type') == 2) {
                $company = new Company();
                $company->name = $user->name;
                $company->details = $request->get('details');
                $company->first_name = $user->first_name;
                $company->last_name = $user->last_name;
                $company->user_id = $user->id;
                $company->sector_id = $request->get('sector_id');

                $media = new Media();
                $company->image_id = $media->saveFile($request->file('logo'));

                $files = array();
                foreach ($request->file('files') as $file){
                    $media = new Media();
                    $files[] = $media->saveFile($file);
                }
                $company->save();
                $company->files()->sync($files);
            }

            //return success or redirect
        }

        $this->data['sectors'] = Sector::published()->get();
        return view('register', $this->data);
    }

}
