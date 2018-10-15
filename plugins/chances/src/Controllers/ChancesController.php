<?php

namespace Dot\Chances\Controllers;

use Action;
use DateTime;
use Dot\Blocks\Models\Block;
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


/*
 * Class ChancesController
 * @package Dot\Chances\Controllers
 */

class ChancesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    public $errors = array();

    /*
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

    /*
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

    /*
     * Edit chance by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $chance = Chance::findOrFail($id);
        $this->errors = new MessageBag();
        if (Request::isMethod("post")) {
            $chance->name = Request::get("name");
            $chance->number = Request::get("number");
            $chance->closing_date = Request::get("closing_date") ? Carbon::createFromFormat('Y-m-d\TH:i', Request::get("closing_date")) : null;
            $chance->file_name = Request::get("file_name", "");
            $chance->file_description = Request::get("file_description", "");
            $chance->status = Request::get("status", 3);
            $chance->approved = Request::get('approved', 1);
            $chance->reason = Request::get("reason", "");
            $chance->value = Request::get("value", "");

            $units = Request::get("units", []);
            $units_quantity = Request::get("units_quantity", []);
            $sectors = Request::get("sectors", []);

            $syncUnit = array();
            foreach ($units as $key => $unit) {
                if (!$units_quantity[$key]) {
                    $this->errors->add("units_names", trans("chances::chances.attributes.units_names") . " " . trans("chances::chances.required") . ".");
                    break;
                }
                $syncUnit[$unit] = ["quantity" => $units_quantity[$key]];
            }

            if ($chance->approved == 0 && $chance->reason == "")
                $this->errors->add("reason", trans("chances::chances.attributes.reason") . " " . trans("chances::chances.required") . ".");
            if (!$units)
                $this->errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
            if (!$sectors)
                $this->errors->add("sectors", trans("chances::chances.attributes.sectors") . " " . trans("chances::chances.required") . ".");

            $chance->validate();
            if ($chance->errors() != null)
                $this->errors->merge($chance->errors());
            if ($this->errors->messages())
                return Redirect::back()->withErrors($this->errors)->withInput(Request::all());

            $chance->save();
            $chance->sectors()->sync($sectors);
            $chance->units()->sync($syncUnit);

            return Redirect::route("admin.chances.edit", array("id" => $chance->id))
                ->with("message", trans("chances::chances.events.created"));
        }

        $this->data["chance"] = $chance;
        $this->data["chances_sectors"] = $chance->sectors->pluck('id')->toArray();
        $this->data["units_quantity"] = $chance->units;
        $this->data["sectors"] = Sector::published()->get();
        $this->data["units"] = Unit::published()->get();
        $this->data['status'] = [0, 1, 2, 3, 4, 5];

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
