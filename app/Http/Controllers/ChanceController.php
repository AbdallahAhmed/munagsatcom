<?php

namespace App\Http\Controllers;

use App\Models\Chance;
use App\Models\Company;
use App\Models\Notifications;
use Carbon\Carbon;
use Dot\Chances\Models\Sector;
use Dot\Chances\Models\Unit;
use Dot\Media\Models\Media;
use Dot\Platform\Controller;
use Illuminate\Support\Facades\DB;
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
        $query = \App\Models\Chance::query()->has('company')
            ->where('status', 0)
            ->orderBy('created_at', 'DESC');
        $this->data['q'] = null;
        $this->data['created_at'] = null;
        $status = $request->get('status');
        $status = $status ? $status : [];
        $this->data['chosen_status'] = $status;

        $query->where(function ($query) use ($status) {
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
                    case 4:
                        $query = $query->orWhere(function ($q) {
                            $q->approved();
                        });
                        break;
                }
            }
        });
        if ($request->get('q')) {
            $q = trim(urldecode($request->get('q')));
            $query = $query->where('name', 'like', '%' . $q . '%');
            $this->data['q'] = $q;
        }
        if ($request->get('created_at')) {
            $query = $query->whereDate('created_at', '=', \Carbon\Carbon::parse($request->get('created_at'))->toDateString());
            $this->data['created_at'] = $request->get('created_at');
        }
        $this->data['chances'] = $query->paginate(5);
        $this->data['status'] = [0, 1];//[0,1,2,3,4,5];
//        return view('chances.index', $this->data);
        return view('centers.coming-soon');
    }

    /**
     * GET {lang}/chances/{id}
     * @route chances.show
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $slug)
    {

        $chance = \App\Models\Chance::where('slug', '=', $slug)->where('status', 0)->firstOrFail();

        $this->data['chance'] = $chance;
        $this->data['otherUnits'] = DB::table('other_units')->where('chance_id', $chance->id)->get();
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
            'file' => 'mimes:jpg,png,jpeg,doc,docx,txt,pdf,zip|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()->toArray()['file'][0]], 200);
        }
        $media = new Media();
        $file_id = $media->saveFile($file);
        $chance->offers()->attach($file_id, ['user_id' => fauth()->id(), 'approved' => 0]);
        $chance->increment('offers');
        return response()->json(["success" => true], 200);
    }

    /**
     * POST {lang}/company/{id}/chances/approveOffers
     * @route chances.offers.approve
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveOffers(Request $request, $id)
    {
        $chance_id = $request->get('chance_id');
        $user_id = $request->get('user_id');

        $chance = Chance::findOrFail($id);
        $chance->status = 4;
        $chance->save();

        DB::table('chances_offers_files')
            ->where('chance_id', $chance_id)
            ->update(['approved' => 0]);

        DB::table('chances_offers_files')
            ->where([
                ['user_id', $user_id],
                ['chance_id', $chance_id]
            ])
            ->update(['approved' => 1]);

        //notification for requested user
        $notification = new Notifications();
        $notification->key = "chance.approval";
        $notification->user_id = $user_id;
        $notification->data = json_encode(["chance_id" => $chance_id]);
        $notification->save();

        //notification for owner user
        $notification = new Notifications();
        $notification->key = "chance.self.approval";
        $notification->user_id = fauth()->id();
        $notification->data = json_encode(["chance_id" => $chance_id, "user_id" => $user_id]);
        $notification->save();

        return response()->json(['success' => true], 200);
    }

    /** POST {lang}/company/{id}/chance/create
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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
                //  'file_name' => 'required',
                //  'file_description' => 'required',
                'files.*' => 'required|mimes:pdf',
                'sector_id' => 'required'
            ], ['mimes' => trans('chances.file_type_error')]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $chance->name = $request->get("name");
            $chance->number = $request->get("number");
            $chance->value = $request->get("chance_value", '');
            $chance->sector_id = $request->get("sector_id");
            $chance->closing_date = $request->get("closing_date") ? Carbon::createFromFormat('m-d-Y', $request->get("closing_date")) : null;
            $chance->file_name = $request->get("file_name", "");
            $chance->file_description = $request->get("file_description", "");
            $chance->status = 3;
            $chance->approved = 1;
            $chance->company_id = $id;
            $chance->user_id = fauth()->user()->id;

            $units = $request->get("units", []);
            $units_quantity = $request->get("units_quantity", []);
            $units_name = $request->get("units_name", []);
            $syncUnit = array();
            foreach ($units as $key => $unit) {
                if ($unit != "" && !$units_quantity[$key]) {
                    $errors->add("units_names", trans("chances::chances.attributes.quantity") . " " . trans("services::centers.required") . ".");
                    break;
                }
                if ($unit != '' && !$units_name[$key]) {
                    $errors->add("units_names", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                    break;
                }
                if ($unit != "")
                    $syncUnit[$unit] = ["quantity" => $units_quantity[$key], "name" => $units_name[$key]];
            }

            $others_units = $request->get("others_units", []);
            if (count($others_units)) {
                $others_quantity = $request->get("others_quantity", []);
                $others_names = $request->get("others_name", []);
                foreach ($others_units as $key => $unit) {
                    if (!$unit) {
                        $errors->add("units", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                        break;
                    }
                    if (!$others_names[$key] && ($unit != null || !$others_quantity[$key])) {
                        $errors->add("units_names", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                        break;
                    }
                    if (!$others_quantity[$key] && ($unit != null || !$others_names[$key])) {
                        $errors->add("units_quantity", trans("chances::units.attributes.quantity") . " " . trans("services::centers.required") . ".");
                        break;
                    }
                }
            }

            if (!$units || empty($units[0]))
                $errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
            if ($errors->messages())
                return redirect()->back()->withErrors($errors)->withInput($request->all());

            $chance->save();

            if ($request->file('files')) {
                foreach (($request->file('files')) as $key => $file) {
                    $media = new Media();
                    $mid = $media->saveFile($file);
                    DB::table('chances_files')->insert([
                        'chance_id' => $chance->id,
                        'media_id' => $mid,
                        'file_name' => $request->get('files_names')[$key] ? $request->get('files_names')[$key] : ''
                    ]);
                }
            }
            foreach ($others_units as $key => $unit) {
                DB::table('other_units')->insert([
                    'chance_id' => $chance->id,
                    'name' => $others_names[$key],
                    'unit' => $unit,
                    'quantity' => $others_quantity[$key]
                ]);
            }

            foreach ($units as $key => $unit) {
                DB::table('chances_units')->insert([
                    'chance_id' => $chance->id,
                    'unit_id' => $unit,
                    'quantity' => $units_quantity[$key],
                    'name' => $units_name[$key]
                ]);
            }

            $notification = new Notifications();
            $notification->key = "chance.add";
            $notification->user_id = fauth()->id();
            $notification->isRead = 0;
            $data = array();
            $data['chance_id'] = $chance->id;
            $notification->data = json_encode($data);
            $notification->save();

            $trans = pay(option('rules_add_chances', 0), 'add.chance', $chance->id);


            return redirect()->route('chances.create', ['id' => $company->id])->with('status', trans('app.chances.created_successfully') . ' <a  class="text-primary" href="' . $trans->invoice_path . '">' . trans('app.invoice') . '</a>');
        }

        $this->data["sectors"] = Sector::published()->get();
        $this->data["units"] = Unit::published()->get();

//        return view('chances.create', $this->data);
        return view('chances.coming-soon');

    }

    /** POST {lang}/company/{id}/chance/{chance_id}/update
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update(Request $request, $company_id, $id)
    {
        $errors = new MessageBag();
        $this->data['chance'] = $chance = Chance::findOrFail($id);
        $this->data['company'] = $company = Company::findOrFail($company_id);
        if ($request->method() == "POST") {
            $validator = Validator::make($request->all(), [
                "name" => 'required',
                'number' => 'required',
                'closing_date' => 'required',
                'files.*' => 'required|mimes:pdf',
                'sector_id' => 'required'
            ], ['mimes' => trans('chances.file_type_error')]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $chance->name = $request->get("name");
            $chance->number = $request->get("number");
            $chance->sector_id = $request->get("sector_id");
            $chance->closing_date = $chance->closing_date = $request->get("closing_date") ? \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $request->get("closing_date")) : null;

            $units = $request->get("units", []);
            $units_quantity = $request->get("units_quantity", []);
            $units_name = $request->get("units_name", []);
            $syncUnit = array();
            foreach ($units as $key => $unit) {
                if ($unit != "" && !$units_quantity[$key]) {
                    $errors->add("units_names", trans("chances::chances.attributes.quantity") . " " . trans("services::centers.required") . ".");
                    break;
                }
                if ($unit != '' && !$units_name[$key]) {
                    $errors->add("units_names", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                    break;
                }
                if ($unit != "")
                    $syncUnit[$unit] = ["quantity" => $units_quantity[$key], "name" => $units_name[$key]];
            }

            $others_units = $request->get("others_units", []);
            if (count($others_units)) {
                $others_quantity = $request->get("others_quantity", []);
                $others_names = $request->get("others_name", []);
                foreach ($others_units as $key => $unit) {
                    if (!$unit) {
                        $errors->add("units", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                        break;
                    }
                    if (!$others_names[$key] && ($unit != null || !$others_quantity[$key])) {
                        $errors->add("units_names", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                        break;
                    }
                    if (!$others_quantity[$key] && ($unit != null || !$others_names[$key])) {
                        $errors->add("units_quantity", trans("chances::units.attributes.quantity") . " " . trans("services::centers.required") . ".");
                        break;
                    }
                }
            }
            if (!$units || empty($units[0]))
                $errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
            if ($errors->messages())
                return redirect()->back()->withErrors($errors)->withInput($request->all());

            DB::table('chances_units')->where('chance_id', $chance->id)->delete();
            foreach ($units as $key => $unit) {
                DB::table('chances_units')->insert([
                    'chance_id' => $chance->id,
                    'unit_id' => $unit,
                    'quantity' => $units_quantity[$key],
                    'name' => $units_name[$key]
                ]);
            }


            if ($request->filled('deleted_files')) {
                foreach ($request->get('deleted_files') as $key => $file) {
                    if ($file) {
                        DB::table('chances_files')->where([
                            ['chance_id', $chance->id],
                            ['media_id', $request->get('deleted_media')[$key]],
                            ['file_name', $file]
                        ])->delete();
                    }
                }
            }
            if ($request->file('new_files')) {
                foreach (($request->file('new_files')) as $key => $file) {
                    if ($request->get('new_names')[$key]) {
                        $media = new Media();
                        $mid = $media->saveFile($file);
                        DB::table('chances_files')->insert([
                            'chance_id' => $chance->id,
                            'media_id' => $mid,
                            'file_name' => $request->get('new_names')[$key] ? $request->get('new_names')[$key] : ''
                        ]);
                    }
                }
            }
            DB::table('other_units')->where(['chance_id' => $chance->id])->delete();
            foreach ($others_units as $key => $unit) {
                DB::table('other_units')->insert([
                    'chance_id' => $chance->id,
                    'name' => $others_names[$key],
                    'unit' => $unit,
                    'quantity' => $others_quantity[$key]
                ]);
            }

            $chance->save();

            return redirect()->route('chances.update', ['id' => $company->id, 'chance_id' => $chance->id])->with('status', trans('app.chances.updated_successfully'));
        }

        $this->data["sectors"] = Sector::published()->get();

        $this->data["units"] = Unit::published()->get();
        $this->data['files'] = $chance->files;
        $this->data['otherUnits'] = DB::table('other_units')->where('chance_id', $chance->id)->get();

        return view('chances.edit', $this->data);
//        return view('chances.coming-soon');

    }

    /**
     * GET {lang?}/changes/{id}/download
     * @route changes.download
     * @param Request $request
     * @param $id
     * @return string
     */
    public function download(Request $request, $id)
    {
        $chance = Chance::whereNotIn('status', [3, 5])->where('id', $id)->firstOrFail();
        if (!$chance) {
            abort(404);
        }
        $chance->increment('downloads');

        if (!file_exists(uploads_path($chance->media->path))) {
            return 'تم مسحها المرفق';
        }
        return response()->download(uploads_path($chance->media->path), $chance->name, ['Content-Type: application/pdf']);
    }

    /**
     * GET company/{id}/chances/{id}/offers
     * @route chances.offers.show
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function showOffer(Request $request, $id, $chance_id)
    {
        $chance = Chance::whereNotIn('status', [3, 5])->where('id', $chance_id)->firstOrFail();
        $offers = DB::table('chances_offers_files')->where('chance_id', $chance->id)->where('user_id', '<>', 0)->get()->groupBy('user_id');
        $approved = DB::table('chances_offers_files')->where([
            ['chance_id', $chance_id],
            ['approved', 1]
        ])->first();
        $is_approved = $approved ? $approved->user_id : 0;
        $view = view('companies.partials.offers', ['offers' => $offers, 'company_id' => $id, 'is_approved' => $is_approved])->render();
        return $view;
    }
}
