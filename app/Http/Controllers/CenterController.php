<?php

namespace App\Http\Controllers;

use App\Mail\CenterContactEmail;
use App\Models\Center;
use App\Models\Company;
use App\Models\Notifications;
use App\User;
use Dot\Auth\Auth;
use Dot\Chances\Models\Sector;
use Dot\Media\Models\Media;
use Dot\Services\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;


class CenterController extends Controller
{
    /**
     * Data unit
     * @var array
     */
    public $data = array();

    /**
     * GET {lang}/centers
     * @route centers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $query = Center::published();
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
        $query->whereHas('sector', function ($query) {
            $query->where('status', 1);
        });
        $this->data['centers'] = $query->paginate(5);
        $this->data['services'] = Service::published()->get();
        $this->data['sectors'] = Sector::published()->get();

//        return view('centers.index', $this->data);
        return view('centers.coming-soon');
    }


    /**
     * POST {lang}/company/{id}/center/create
     * @route centers.create
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request, $id)
    {
        if (!fauth()->user()->can_buy) {
            return abort(403);
        }

        if (/*mypoints()*/ 50 < option('service_center_add', 0)) {
            return 'Can\'nt add this center';
        }
        $this->data['company'] = $company = Company::findOrFail($id);
        if ($request->method() == "POST") {
            $validator = Validator::make($request->all(), [
                "name" => 'required',
                'sector_id' => 'required',
                'address' => 'required',
                'logo' => 'mimes:jpg,png,jpeg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $center = new Center();
            $center->name = $request->get("name");
            $center->sector_id = $request->get("sector_id");
            $center->address = $request->get("address");
            $center->mobile_number = $request->get('mobile_number', "");
            $center->phone_number = $request->get('phone_number', "");
            $center->email_address = fauth()->user()->email;
            $center->lat = $request->get('lat');
            $center->lng = $request->get('lng');
            $center->user_id = fauth()->user()->id;
            $center->company_id = $company->id;
            $center->status = $request->get('status', 0);
            $center->approved = 1;
            $center->reason = $request->get('reason');
            if ($request->hasFile('logo')) {
                $center->image_id = (new Media())->saveFile($request->file('logo'));
            }

            $center->save();
            $center->services()->sync(($request->get("services", [])));

            pay(option('service_center_add', 0), 'center.add', $center->id);

            return redirect()->route('centers.create', ['id' => $company->id])->with('status', trans('app.centers.created_successfully'));
        }

        $this->data['sectors'] = Sector::published()->get();
        $this->data['services'] = Service::published()->get();

        return view('centers.create', $this->data);
    }

    /**
     * POST {lang}/company/{id}/center/update
     * @route centers.update
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $company_id, $id)
    {
        $center = Center::findOrFail($id);
        if ($request->method() == "POST") {
            $validator = Validator::make($request->all(), [
                "name" => 'required',
                'sector_id' => 'required',
                'address' => 'required',
                'logo' => 'mimes:jpg,png,jpeg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $center->name = $request->get("name");
            $center->sector_id = $request->get("sector_id");
            $center->address = $request->get("address");
            $center->mobile_number = $request->get('mobile_number', "");
            $center->phone_number = $request->get('phone_number', "");
            $center->email_address = fauth()->user()->email;
            $center->lat = $request->get('lat');
            $center->lng = $request->get('lng');
            if (!$request->get('image_id')) {
                if ($request->hasFile('logo')) {
                    $center->image_id = (new Media())->saveFile($request->file('logo'));
                }
            }
            $center->save();
            $center->services()->sync(($request->get("services", [])));
            $notification = new Notifications();

            $notification->key = "center.update";
            $notification->user_id = fauth()->id();
            $notification->isRead = 0;
            $data = array();
            $data['center_id'] = $center->id;
            $notification->data = json_encode($data);
            $notification->save();

            return redirect()->route('centers.update', ['id' => $company_id, 'center_id' => $id])->with('status', trans('app.centers.updated_successfully'));
        }

        $this->data['sectors'] = Sector::published()->get();
        $this->data['services'] = Service::published()->get();
        $this->data['company'] = Company::find($company_id);
        $this->data['center'] = $center;
        $this->data["centers_services"] = $center->services->pluck("id")->toArray();

        return view('centers.edit', $this->data);
    }

    /**
     * GET {lang}/centers/{id}
     * @route centers.show
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $slug)
    {
        $center = Center::published()->where('slug', '=', $slug)->firstOrFail();
        $this->data['center'] = $center;
        return view('centers.center', $this->data);
    }

    /**
     * POST {lang}/centers/contact
     * @route centers.contact
     * @param Request $request
     */
    public function contact(Request $request)
    {
        Mail::to($request->get('email'))->send(new CenterContactEmail($request));
    }

}
