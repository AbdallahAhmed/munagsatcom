<?php

namespace App\Http\Controllers;

use Action;
use Dot\Chances\Chances;
use Dot\Chances\Models\Chance;
use Dot\Chances\Models\Sector;
use Dot\Chances\Models\Unit;
use Dot\Platform\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Redirect;
use Request;
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

    public function store()
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

    }

    public function getUnits()
    {
        return response()->json([
            "view" => view("chances::add-units", ['units' => Unit::published()->get()])->render()
        ]);
    }

    public function saveFile($file)
    {

        $parts = explode(".", $file->getClientOriginalName());
        $extension = end($parts);
        $filename = time() * rand() . "." . strtolower($extension);

        $file_directory = UPLOADS_PATH . "/chances" . date("/Y/m");

        File::makeDirectory($file_directory, 0777, true, true);

        $file->move($file_directory, $filename);

        return  date("/Y/m")."/".$filename;
    }

    public function validateFile($file)
    {
        $flag = true;
        $allowed_types = option("media_allowed_file_types");
        $parts = explode(".", $file->getClientOriginalName());
        $extension = end($parts);
        if (!in_array($extension, explode(',', $allowed_types))){
            $this->errors->add("file type", "File type not supported");
            $flag = false;
        }
        if ($file->getSize() > option("media_max_file_size")){
            $this->errors->add("file size", "File size is too large");
            $flag = false;
        }
        return $flag;
    }

}
