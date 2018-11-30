<?php

namespace App\Http\Controllers;

use Action;
use Dot\Chances\Chances;
use Dot\Chances\Models\Chance;
use Dot\Chances\Models\Sector;
use Dot\Chances\Models\Unit;
use Dot\Platform\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Redirect;
use View;
use File;

class ChanceController extends Controller
{
    public $data = array();
    public $errors = null;


    public function create()
    {
        $this->data['sectors'] = Sector::published()->get();
        $this->data['units'] = Unit::published()->get();
        return view('chances.create', $this->data);
    }

    public function index(Request $request){
        $query = \App\Models\Chance::query();
        $this->data['q'] = null;
        $this->data['created_at'] = null;
        $status = $request->get('status');
        $status = $status ? $status : [];
        $this->data['status'] = $status;

        foreach ($status as $st){
            switch ($st){
                case 0:
                    $query = $query->orWhere(function ($q){
                        $q->opened();
                    });
                    break;
                case 1:
                    $query = $query->orWhere(function ($q){
                        $q->closed();
                    });
                    break;
                case 2:
                    $query = $query->orWhere(function ($q){
                        $q->cancelled();
                    });
                    break;
                case 3:
                    $query = $query->orWhere(function ($q){
                        $q->pending();
                    });
                    break;
                case 4:
                    $query = $query->orWhere(function ($q){
                        $q->approved();
                    });
                    break;
                case 5:
                    $query = $query->orWhere(function ($q){
                        $q->rejected();
                    });
                    break;
            }
        }
        if($request->get('q')){
            $q = trim(urldecode($request->get('q')));
            $query = $query->where('name','like', '%'.$q.'%');
            $this->data['q'] = $q;
        }
        if($request->get('created_at')){
            $query = $query->whereDate('created_at', '=', \Carbon\Carbon::parse($request->get('created_at'))->toDateString());
            $this->data['created_at'] = $request->get('created_at');
        }
        $this->data['chances'] = $query->paginate(1);
        $this->data['status'] = [0,1];//[0,1,2,3,4,5];
        return view('chances.index', $this->data);
    }

    /*public function store()
    {

        $this->errors = new MessageBag();
        $chance = new Chance();

        $chance->name = Request::get("name");
        $chance->number = Request::get("number");
        $chance->file_name = Request::get("file_name");
        $chance->file_description = Request::get("file_description");
        $chance->value = Request::get("value");
        $chance->user_id = Auth::user()->id; //fauth()->user()->id;
        $chance->closing_date = Request::get("closing_date") ? Carbon::createFromFormat('Y-m-d\TH:i', Request::get("closing_date")) : null;

        $units = Request::get("units", []);
        $units_quantity = Request::get("units_quantity", []);
        $sectors = Request::get("sectors", []);
        $file = Request::file("file");

        if ($file && $this->validateFile($file))
            $chance->file_path = $this->saveFile($file);
        else
            $this->errors->add("file", "no file");

        $syncUnit = array();
        foreach ($units as $key => $unit) {
            if (!$units_quantity[$key]) {
                $this->errors->add("units_names", trans("chances::chances.attributes.units_names"));
                break;
            }
            $syncUnit[$unit] = ["quantity" => $units_quantity[$key]];
        }

        if (!$units)
            $this->errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
        if (!$sectors)
            $this->errors->add("sectors", trans("chances::chances.attributes.sectors") . " " . trans("chances::chances.required") . ".");

        if (!$chance->validate()) {
            $this->errors->merge($chance->errors());
            return Redirect::back()->withErrors($this->errors)->withInput(Request::all());
        }
        $chance->save();
        $chance->sectors()->sync($sectors);
        $chance->units()->sync($syncUnit);

        return Redirect::route("chance.create");

    }*/
    public function show(Request $request, $id){

        $chance = \App\Models\Chance::findOrFail($id);
        $diff = \Carbon\Carbon::parse($chance->closing_date)->diffForHumans(\Carbon\Carbon::now());

        $this->data['chance'] = $chance;
        return view('chances.chance', $this->data);
    }

}
