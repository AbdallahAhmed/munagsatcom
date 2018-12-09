<?php

namespace App\Http\Controllers;

use App\Models\Chance;
use App\Models\Company;
use Carbon\Carbon;
use Dot\Chances\Models\Sector;
use Dot\Chances\Models\Unit;
use Dot\Media\Models\Media;
use Dot\Platform\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ChanceController extends Controller
{
    /**
     * Data unit
     * @var array
     */
    public $data = array();

    /**
     * GET {lang}/chances
     * @route chances
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = \App\Models\Chance::query();
        $this->data['q'] = null;
        $this->data['created_at'] = null;
        $status = $request->get('status');
        $status = $status ? $status : [];
        $this->data['chosen_status'] = $status;

        foreach ($status as $st) {
            switch ($st) {
                case 0:
                    $query = $query->orWhere(function ($q) {
                        $q->opened();
                    });
                    break;
                case 1:
                    $query = $query->orWhere(function ($q) {
                        $q->closed();
                    });
                    break;
                case 2:
                    $query = $query->orWhere(function ($q) {
                        $q->cancelled();
                    });
                    break;
                case 3:
                    $query = $query->orWhere(function ($q) {
                        $q->pending();
                    });
                    break;
                case 4:
                    $query = $query->orWhere(function ($q) {
                        $q->approved();
                    });
                    break;
                case 5:
                    $query = $query->orWhere(function ($q) {
                        $q->rejected();
                    });
                    break;
            }
        }
        if ($request->get('q')) {
            $q = trim(urldecode($request->get('q')));
            $query = $query->where('name', 'like', '%' . $q . '%');
            $this->data['q'] = $q;
        }
        if ($request->get('created_at')) {
            $query = $query->whereDate('created_at', '=', \Carbon\Carbon::parse($request->get('created_at'))->toDateString());
            $this->data['created_at'] = $request->get('created_at');
        }
        $this->data['chances'] = $query->paginate(10);
        $this->data['status'] = [0, 1];//[0,1,2,3,4,5];
        return view('chances.index', $this->data);
    }

    /**
     * GET {lang}/chances/{id}
     * @route chances.show
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {

        $chance = \App\Models\Chance::findOrFail($id);

        $this->data['chance'] = $chance;
        return view('chances.chance', $this->data);
    }

    /**
     * POST {lang}/chances/offers
     * @route chances.offers
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOffer(Request $request)
    {
        $chance = \App\Models\Chance::find($request->get('chance_id'));
        $file = $request->file('file');
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:jpg,png,jpeg,doc,docx,txt,pdf,zip'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()->toArray()['file'][0]], 200);
        }
        $media = new Media();
        $file_id = $media->saveFile($file);
        $chance->offers()->syncWithoutDetaching($file_id);

        return response()->json(["success" => true], 200);
    }


    public function store(Request $request, $id)
    {

        $chance = new Chance();
        $errors = new MessageBag();
        $this->data['company'] = $company = Company::findOrFail($id);
        if ($request->method() == "POST") {

            $validator = Validator::make($request->all(), [
                "name" => 'required',
                'number' => 'required',
                'closing_date' => 'required',
                'file_name' => 'required',
                'file_description' => 'required',
                'chance_value' => 'required',
                'file' => 'mimes:jpg,png,jpeg,doc,docx,txt,pdf,zip',
                'sector_id' => 'required'
            ]);
            if ($validator->fails())
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());

            $chance->name = $request->get("name");
            $chance->number = $request->get("number");
            $chance->value = $request->get("chance_value");
            $chance->sector_id = $request->get("sector_id");
            $chance->closing_date = $request->get("closing_date") ? Carbon::createFromFormat('m-d-Y', $request->get("closing_date")) : null;
            $chance->file_name = $request->get("file_name", "");
            $chance->file_description = $request->get("file_description", "");
            $media = new Media();
            $chance->media_id = $media->saveFile($request->file('file'));
            $chance->status = 3;
            $chance->approved = 1;
            $chance->company_id = $id;
            $chance->user_id = fauth()->user()->id;

            $units = $request->get("units", []);
            $units_quantity = $request->get("units_quantity", []);
            $sectors = $request->get("sectors", []);

            $syncUnit = array();
            foreach ($units as $key => $unit) {
                if (!$units_quantity[$key] && $unit != null) {
                    $errors->add("units_names", trans("chances::chances.attributes.reason") . " " . trans("services::centers.required") . ".");
                    break;
                }
                if($unit != "")
                    $syncUnit[$unit] = ["quantity" => $units_quantity[$key]];
            }


            if ($chance->approved == 0 && $chance->reason == "")
                $errors->add("reason", trans("chances::chances.attributes.reason") . " " . trans("chances::chances.required") . ".");
            if (!$units)
                $errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
            /*if (!$sectors)
                $errors->add("sectors", trans("chances::chances.attributes.sectors") . " " . trans("chances::chances.required") . ".");*/
            if ($errors->messages())
                return redirect()->back()->withErrors($errors)->withInput($request->all());

            $chance->save();
            //$chance->sectors()->sync($sectors);
            $chance->units()->sync($syncUnit);

            return redirect()->route('chances.create', ['id'=>$company->id])->with('status', trans('app.chances.created_successfully'));
        }

        $this->data["sectors"] = Sector::published()->get();
        $this->data["units"] = Unit::published()->get();

        return view('chances.create', $this->data);
    }

    /*public function store()
    {

        $this->errors = new MessageBag();
        $chance = new Chance();

        $chance->name = $request->get("name");
        $chance->number = $request->get("number");
        $chance->file_name = $request->get("file_name");
        $chance->file_description = $request->get("file_description");
        $chance->value = $request->get("value");
        $chance->user_id = Auth::user()->id; //fauth()->user()->id;
        $chance->closing_date = $request->get("closing_date") ? Carbon::createFromFormat('Y-m-d\TH:i', $request->get("closing_date")) : null;

        $units = $request->get("units", []);
        $units_quantity = $request->get("units_quantity", []);
        $sectors = $request->get("sectors", []);
        $file = $request->file("file");

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
            return Redirect::back()->withErrors($this->errors)->withInput($request->all());
        }
        $chance->save();
        $chance->sectors()->sync($sectors);
        $chance->units()->sync($syncUnit);

        return Redirect::route("chance.create");

    }*/

}
