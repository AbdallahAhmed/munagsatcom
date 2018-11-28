<?php

namespace App\Http\Controllers;

use App\User;
use Dot\Auth\Auth;
use Dot\Services\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public $data = array();

    public function index(Request $request){
        $query = Center::published();
        if($request->get("sector")){
            $query = $query->where('sector_id', $request->get('sector'));
        }
        if($request->get('center')){
            $query = $query->whereHas('services', function ($query) use ($request){
               $query->where('id', $request->get('center'));
            });
        }
        if($request->get('q')){
            $q = trim(urldecode($request->get('q')));
            $query = $query->where('name','like', '%'.$q.'%');
        }
        $this->data['centers'] = $query->paginate(2);

        return view('centers.index', $this->data);
    }
}
