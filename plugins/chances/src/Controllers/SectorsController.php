<?php

namespace Dot\Chances\Controllers;

use Action;
use Dot\Chances\Models\Sector;
use Dot\Platform\Controller;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Request;
use View;

/*
 * Class SectorsController
 * @package Dot\Chances\Controllers
 */
class SectorsController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all sectors
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

        $query = Sector::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $sectors = $query->paginate($this->data['per_page']);

        $this->data["sectors"] = $sectors;

        return View::make("chances::sectors.show", $this->data);
    }

    /*
     * Delete sector by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $sector = Sector::findOrFail($id);

            $sector->delete();
            $sector->chances()->detach();

        }

        return Redirect::back()->with("message", trans("chances::sectors.events.deleted"));
    }

    /*
     * Create a new sector
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $sector = new Sector();

            $sector->name = Request::get("name");
            $sector->status = Request::get("status", 0);
            $sector->user_id = Auth::user()->id;


            if (!$sector->validate()) {
                return Redirect::back()->withErrors($sector->errors())->withInput(Request::all());
            }

            $sector->save();

            return Redirect::route("admin.sectors.edit", array("id" => $sector->id))
                ->with("message", trans("chances::sectors.events.created"));
        }

        $this->data["sector"] = false;

        return View::make("chances::sectors.edit", $this->data);
    }

    /*
     * Edit sector by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $sector = Sector::findOrFail($id);

        if (Request::isMethod("post")) {

            $sector->name = Request::get("name");
            $sector->status = Request::get("status", 0);

            if (!$sector->validate()) {
                return Redirect::back()->withErrors($sector->errors())->withInput(Request::all());
            }

            $sector->save();

            return Redirect::route("admin.sectors.edit", array("id" => $id))->with("message", trans("chances::sectors.events.updated"));
        }

        $this->data["sector"] = $sector;

        return View::make("chances::sectors.edit", $this->data);
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

            $sector = Sector::findOrFail($id);

            $sector->status = $status;
            $sector->save();

        }

        if ($status) {
            $message = trans("chances::sectors.events.activated");
        } else {
            $message = trans("chances::sectors.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /*
     * Rest Service to search sectors
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $sectors = Sector::search($q)->get()->toArray();

        return json_encode($sectors);
    }
}
