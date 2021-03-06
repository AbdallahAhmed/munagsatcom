<?php

namespace Dot\Services\Controllers;

use Action;
use App\Models\Notifications;
use Dot\Blocks\Models\Block;
use Dot\Chances\Models\Sector;
use Dot\Platform\Controller;
use Dot\Services\Models\Center;
use Dot\Services\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Redirect;
use Request;
use View;

/*
 * Class CentersController
 * @package Dot\Services\Controllers
 */

class CentersController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];
    protected $errors = null;

    /*
     * Show all centers
     * @return mixed
     */
    function index()
    {

        if (Request::isMethod("post")) {
            if (Request::filled("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                    case "activate":
                        return $this->status(1);
                    case "deactivate":
                        return $this->status(0);
                }
            }
        }

        $this->data["sort"] = $sort = (Request::filled("sort")) ? Request::get("sort") : "id";
        $this->data["order"] = $order = (Request::filled("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::filled("per_page")) ? (int)Request::get("per_page") : 40;

        $query = Center::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $centers = $query->paginate($this->data['per_page']);

        $this->data["centers"] = $centers;

        return View::make("services::centers.show", $this->data);
    }

    /**
     * Delete center by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $center = Center::findOrFail($id);

            $center->delete();
            $center->services()->detach();

        }

        return Redirect::back()->with("message", trans("services::centers.events.deleted"));
    }

    /*
     * Create a new block
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $center = new Center();
            $this->errors = new MessageBag();

            $center->name = Request::get("name");
            $center->sector_id = Request::get("sector_id");
            $center->address = Request::get("address");
            $center->mobile_number = Request::get('mobile_number');
            $center->phone_number = Request::get('phone_number');
            $center->email_address = Request::get('email');
            $center->address = Request::get('address');
            $center->image_id = Request::get('logo_id');
            $center->lat = Request::get('lat');
            $center->lng = Request::get('lng');
            $center->user_id = Auth::user()->id;
            $center->status = Request::get('status', 0);
            $center->approved = Request::get('approved');
            $center->reason = Request::get('reason');

            $center->rate = max(Request::get('rate', 0), 0);


            if ($center->approved == 0 && $center->reason == '') {
                $this->errors->add('reason_reject', trans("services::centers.attributes.reason") . " " . trans("chances::chances.required") . ".");
            }
            $center->validate();
            if ($center->errors() != null)
                $this->errors->merge($center->errors());
            if ($this->errors->messages())
                return Redirect::back()->withErrors($this->errors->messages())->withInput(Request::all());

            $center->save();
            $center->services()->sync(Request::get("centers_services", []));

            return Redirect::route("admin.centers.edit", array("id" => $center->id))
                ->with("message", trans("services::centers.events.created"));
        }

        $this->data["center"] = false;
        $this->data["centers_services"] = array();
        $this->data['sectors'] = Sector::published()->get();
        $this->data['services'] = Service::published()->get();


        return View::make("services::centers.edit", $this->data);
    }

    /**
     * Edit center by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $center = Center::findOrFail($id);
        $this->errors = new MessageBag();


        if (Request::isMethod("post")) {
            $oldStatus = $center->approved;
            $center->name = Request::get("name");
            $center->sector_id = Request::get("sector_id");
            $center->address = Request::get("address");
            $center->mobile_number = Request::get('mobile_number');
            $center->phone_number = Request::get('phone_number');
            $center->email_address = Request::get('email');
            $center->address = Request::get('address');
            $center->image_id = Request::get('logo_id');
            $center->lat = Request::get('lat');
            $center->lng = Request::get('lng');
            $center->user_id = Auth::user()->id;
            $center->status = Request::get('status', 0);
            $center->approved = $newStatus = Request::get('approved');
            $center->reason = Request::get('reason');
            $center->rate = max(Request::get('rate', 0), 0);

            if ($center->approved == 0 && empty($center->reason)) {
                $this->errors->add('reason_reject', trans("services::centers.attributes.reason") . " " . trans("chances::chances.required") . ".");
            }
            $center->validate();
            if ($center->errors() != null) {
                $this->errors->merge($center->errors());
            }
            if ($this->errors->messages()) {
                return Redirect::back()->withErrors($this->errors->messages())->withInput(Request::all());
            }
            $center->save();

            if ($newStatus != $oldStatus) {
                if ($newStatus == 1) {
                    pay(option('service_center_add', 0), 'center.add.approved', $center->id);
                    $notification = new Notifications();
                    $notification->key = "center.pay";
                    $notification->user_id = $center->user_id;
                    $data = array();
                    $data['center_id'] = $center->id;
                    $notification->data = json_encode($data);
                    $notification->save();
                } else {
                    refund(option('service_center_add', 0), 'center.add.disapproved', $center->id);
                    $notification = new Notifications();
                    $notification->key = "center.refund";
                    $notification->user_id = $center->user_id;
                    $data = array();
                    $data['center_id'] = $center->id;
                    $notification->data = json_encode($data);
                    $notification->save();
                }
            }

            $center->services()->sync(Request::get("centers_services", []));
            return Redirect::route("admin.centers.edit", array("id" => $id))->with("message", trans("services::centers.events.updated"));
        }

        $this->data["center"] = $center;
        $this->data["centers_services"] = $center->services->pluck("id")->toArray();
        $this->data['sectors'] = Sector::published()->get();
        $this->data['services'] = Service::published()->get();

        return View::make("services::centers.edit", $this->data);
    }

    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $center = Center::findOrFail($id);
            $center->status = $status;
            $center->save();
        }

        if ($status) {
            $message = trans("services::centers.events.activated");
        } else {
            $message = trans("services::centers.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /*
     * Rest Service to search centers
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $center = Center::search($q)->get()->toArray();

        return json_encode($center);
    }
}
