<?php

namespace App\Http\Controllers;

use App\Mail\CenterContactEmail;
use App\Models\Center;
use App\User;
use Dot\Auth\Auth;
use Dot\Chances\Models\Sector;
use Dot\Services\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CenterController extends Controller
{
    public $data = array();

    public function index(Request $request){
        $query = Center::published();
        $this->data['sector_id'] = null;
        $this->data['service_id'] = null;
        $this->data['q'] = null;

        if($request->get("sector_id")){
            $query = $query->where('sector_id', $request->get('sector_id'));
            $this->data['sector_id'] = $request->get("sector_id");
        }
        if($request->get('service_id')){
            $query = $query->whereHas('services', function ($query) use ($request){
               $query->where('id', $request->get('service_id'));
            });
            $this->data['service_id'] = $request->get("service_id");
        }
        if($request->get('q')){
            $q = trim(urldecode($request->get('q')));
            $query = $query->where('name','like', '%'.$q.'%');
            $this->data['q'] = $q;
        }
        if($request->get('price_to')){
            $to = $request->get('price_to');
            $from = $request->get('price_from', 100);

        }
        $this->data['centers'] = $query->paginate(2);
        $this->data['services'] = Service::published()->get();
        $this->data['sectors'] = Sector::published()->get();

        return view('centers.index', $this->data);
    }

    public function show(Request $request, $id){
        $center = Center::published()->where('id', $id)->firstOrFail();
        $this->data['center'] = $center;
        return view('centers.center', $this->data);
    }

    public function contact(Request $request){
        Mail::to($request->get('email'))->send(new CenterContactEmail($request));
    }
}
