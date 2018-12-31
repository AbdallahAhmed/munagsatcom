<?php

namespace Dot\Chances\Controllers;

use Action;
use Dot\Chances\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Dot\Platform\Controller;
use Illuminate\Support\MessageBag;
use Redirect;
use Request;
use View;

/*
 * Class UnitsController
 * @package Dot\Chances\Controllers
 */

class UnitsController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all units
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

        $query = Unit::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $units = $query->paginate($this->data['per_page']);

        $this->data["units"] = $units;

        return View::make("chances::units.show", $this->data);
    }

    /*
     * Delete unit by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];
        $error = new MessageBag();
        foreach ($ids as $id) {

            $unit = Unit::findOrFail($id);
            if ($unit->chances()->count() > 0) {
                $error_id [] = $id;
                $error->add('cat', $unit->name . " لا يمكن حذفه لان يوجد به فرص ");
                continue;
            }
            $unit->delete();
            $unit->chances()->detach();

        }
        if ($error->count() > 0)
            return Redirect::back()->withErrors($error);

        return Redirect::back()->with("message", trans("chances::units.events.deleted"));
    }

    /*
     * Create a new unit
     * @return mixed
     */
    public function create()
    {


        if (Request::isMethod("post")) {

            $unit = new Unit();

            $unit->name = Request::get("name");
            $unit->status = Request::get("status", 0);
            $unit->user_id = Auth::user()->id;


            if (!$unit->validate()) {
                return Redirect::back()->withErrors($unit->errors())->withInput(Request::all());
            }

            $unit->save();

            return Redirect::route("admin.units.edit", array("id" => $unit->id))
                ->with("message", trans("chances::units.events.created"));
        }

        $this->data["unit"] = false;

        return View::make("chances::units.edit", $this->data);
    }

    /*
     * Edit unit by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $unit = Unit::findOrFail($id);

        if (Request::isMethod("post")) {

            $unit->name = Request::get("name");
            $unit->status = Request::get("status", 0);

            if (!$unit->validate()) {
                return Redirect::back()->withErrors($unit->errors())->withInput(Request::all());
            }

            $unit->save();

            return Redirect::route("admin.units.edit", array("id" => $id))->with("message", trans("chances::units.events.updated"));
        }

        $this->data["unit"] = $unit;

        return View::make("chances::units.edit", $this->data);
    }


    /**
     * Activating / Deactivating sector by id
     * @param $status
     * @return mixed
     */
    public function status()
    {
        $ids = Request::get("id");
        $status = Request::get("status");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $unit = Unit::findOrFail($id);

            $unit->status = $status;
            $unit->save();

        }

        if ($status) {
            $message = trans("chances::sectors.events.activated");
        } else {
            $message = trans("chances::sectors.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /*
     * Rest Service to search units
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $units = Unit::search($q)->get()->toArray();

        return json_encode($units);
    }
}
