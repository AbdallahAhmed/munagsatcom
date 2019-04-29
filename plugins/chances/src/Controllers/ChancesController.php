<?php

namespace Dot\Chances\Controllers;

use Action;
use App\Models\Notifications;
use DateTime;
use Dot\Blocks\Models\Block;
use Dot\Chances\Chances;
use Dot\Chances\Models\Chance;
use Dot\Chances\Models\Sector;
use Dot\Chances\Models\Unit;
use Dot\Platform\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Redirect;
use Request;
use View;
use File;


/**
 * Class ChancesController
 * @package Dot\Chances\Controllers
 */
class ChancesController extends Controller
{

    /**
     * View payload
     * @var array
     */
    protected $data = [];

    public $errors = array();

    /**
     * Show all chances
     * @return mixed
     */
    function index()
    {

        if (Request::isMethod("post")) {
            if (Request::filled("action")) {
                switch (Request::get("action")) {
                    case "delete":
                        return $this->delete();
                }
            }
        }

        $this->data["sort"] = $sort = (Request::filled("sort")) ? Request::get("sort") : "id";
        $this->data["order"] = $order = (Request::filled("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::filled("per_page")) ? (int)Request::get("per_page") : 40;

        $query = Chance::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("user_id")) {
            $query->where("user_id", Request::get("user_id"));
        }

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $chances = $query->paginate($this->data['per_page']);

        $this->data["chances"] = $chances;

        return View::make("chances::show", $this->data);
    }

    /**
     * Delete chance by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $chance = Chance::findOrFail($id);

            $chance->delete();
            $chance->units()->detach();
            $chance->sectors()->detach();

        }

        return Redirect::back()->with("message", trans("chances::chances.events.deleted"));
    }

    /**
     * Edit chance by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $this->errors = new MessageBag();
        $chance = Chance::findOrFail($id);
        if (Request::ajax()) {
            $unit = new Unit();

            $unit->name = Request::get("unit_name");
            $unit->status = 1;
            $unit->user_id = Auth::id();
            $name = Request::get('name', "");
            $quantity = Request::get('quantity', "");

            if ($quantity == "")
                $this->errors->add('quantity', trans("chances::chances.attributes.quantity") . " " . trans("services::centers.required") . ".");
            if ($name == "")
                $this->errors->add("units_names", trans("chances::units.attributes.unit") . " " . trans("services::centers.required") . ".");
            if (!$unit->validate() && $unit->errors() != null)
                $this->errors->merge($unit->errors());
            if ($this->errors->messages())
                return response()->json(['success' => false, 'errors' => $this->errors]);

            $unit->save();
            DB::table('chances_units')->insert([
                'chance_id' => $id,
                'unit_id' => $unit->id,
                'quantity' => $quantity,
                'name' => $name
            ]);
            DB::table('other_units')->where([
                ['chance_id', $id],
                ['name', $name],
                ['quantity', $quantity]
            ])->delete();

            return response()->json(['success' => true]);
        }
        $chance = Chance::findOrFail($id);
        if (Request::isMethod("post")) {
            $oldStatus = $chance->approved;
            $chance->name = Request::get("name");
            $chance->number = Request::get("number");
            $chance->closing_date = Request::get("closing_date") ? Carbon::createFromFormat('Y-m-d', Request::get("closing_date")) : null;
            $chance->file_name = Request::get("file_name", "");
            $chance->file_description = Request::get("file_description", "");
            $chance->status = Request::get("status", 3);
            $chance->approved = $newStatus = Request::get('approved', $chance->approved);
            $chance->reason = Request::get("reason", "");
            $chance->sector_id = Request::get("sector_id");
            $chance->value = Request::get("value", "");

            $units = Request::get("units", []);
            $units_quantity = Request::get("units_quantity", []);
            $units_name = Request::get("units_names", []);
            $sectors = Request::get("sectors", []);

            $syncUnit = array();
            foreach ($units as $key => $unit) {
                if (!$units_quantity[$key]) {
                    $this->errors->add("units_names", trans("chances::chances.attributes.quantity") . " " . trans("services::centers.required") . ".");
                    break;
                }
                if (!$units_name[$key]) {
                    $this->errors->add("units_names", trans("chances::units.attributes.name") . " " . trans("services::centers.required") . ".");
                    break;
                }
                $syncUnit[$unit] = ["quantity" => $units_quantity[$key], 'name' => $units_name[$key]];
            }

            if ($chance->approved == 0 && $chance->reason == "") {
                $this->errors->add("reason", trans("chances::chances.attributes.reason") . " " . trans("chances::chances.required") . ".");
            }
            if (!$units) {
                $this->errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
            }

            $chance->validate();
            if ($chance->errors() != null)
                $this->errors->merge($chance->errors());
            if ($this->errors->messages())
                return Redirect::back()->withErrors($this->errors)->withInput(Request::all());


            $chance->save();
            DB::table('chances_units')->where('chance_id', $chance->id)->delete();
            foreach ($units as $key => $unit) {
                DB::table('chances_units')->insert([
                    'chance_id' => $id,
                    'unit_id' => $unit,
                    'quantity' => $units_quantity[$key],
                    'name' => $units_name[$key]
                ]);
            }
            if ($newStatus != $oldStatus) {
                if ($newStatus == 1) {
                    pay(option('rules_add_chances', 0), 'chances.add.approved', $chance->id);
                    $notification = new Notifications();
                    $notification->key = "chance.pay";
                    $notification->user_id = $chance->user_id;
                    $data = array();
                    $data['chance_id'] = $chance->id;
                    $notification->data = json_encode($data);
                    $notification->save();
                } else {
                    refund(option('rules_add_chances', 0), 'chances.add.disapproved', $chance->id);
                    $notification = new Notifications();
                    $notification->key = "chance.refund";
                    $notification->user_id = $chance->user_id;
                    $data = array();
                    $data['chance_id'] = $chance->id;
                    $notification->data = json_encode($data);
                    $notification->save();
                }
            }
            //$chance->units()->sync($syncUnit);


            return Redirect::route("admin.chances.edit", array("id" => $chance->id))
                ->with("message", trans("chances::chances.events.created"));
        }

        $this->data["chance"] = $chance;
        $this->data["chances_sectors"] = $chance->sectors->pluck('id')->toArray();
        $this->data["units_quantity"] = $chance->units;
        $this->data["sectors"] = Sector::published()->get();
        $this->data["units"] = Unit::published()->get();
        $this->data['status'] = [0, 1, 2, 3, 4, 5];
        $this->data['other_units'] = DB::table('other_units')->where('chance_id', $chance->id)->get();

        return View::make("chances::edit", $this->data);
    }

    /*
     * Rest Service to search chances
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $chances = Chance::search($q)->get()->toArray();

        return json_encode($chances);
    }
}
