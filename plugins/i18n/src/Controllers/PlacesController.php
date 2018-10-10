<?php

namespace Dot\I18n\Controllers;

use Action;
use Auth;
use Dot\I18n\Models\Place;
use Dot\Platform\Controller;
use Redirect;
use Request;
use View;

/*
 * Class PlacesController
 * @package Dot\Places\Controllers
 */

class PlacesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];


    /*
     * Show all places
     * @param $parent int
     * @return mixed
     */
    function index($parent = 0)
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

        $query = Place::where("parent", $parent)->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $places = $query->paginate($this->data['per_page']);

        $this->data["places"] = $places;
        $this->data["country"] = Place::find($parent);

        return View::make("i18n::places.show", $this->data);
    }

    /*
     * Create a new place
     * @return mixed
     */
    public function create($parent = 0)
    {

        if (Request::isMethod("post")) {

            $place = new Place();

            $place->name = Request::get("name");
            $place->currency = Request::get("currency");
            $place->code = Request::get("code");
            $place->lat = Request::get("lat");
            $place->lng = Request::get("lng");
            $place->image_id = Request::get("image_id");
            $place->status = Request::get("status");
            $place->parent = $parent;

            if ($parent == 0) {
                $place->rules(
                    ['code' => 'required|unique:places'],
                    [],
                    ['code' => trans('i18n::places.attributes.code')]
                );
            }

            // Fire saving action

            Action::fire("place.saving", $place);

            if (!$place->validate()) {
                return Redirect::back()->withErrors($place->errors())->withInput(Request::all());
            }

            $place->save();

            // Fire saved action

            Action::fire("place.saved", $place);

            return Redirect::route("admin.places.edit", array("id" => $place->id, "parent" => $parent))
                ->with("message", trans("i18n::places.events.created"));
        }

        $this->data["place"] = false;
        $this->data["country"] = Place::find($parent);

        return View::make("i18n::places.edit", $this->data);
    }

    /*
     * Edit place by id
     * @param $id
     * @return mixed
     */
    public function edit($id, $parent = 0)
    {
        $place = Place::findOrFail($id);

        if (Request::isMethod("post")) {

            $place->name = Request::get("name");
            $place->currency = Request::get("currency");
            $place->code = Request::get("code");
            $place->lat = Request::get("lat");
            $place->lng = Request::get("lng");
            $place->image_id = Request::get("image_id");
            $place->status = Request::get("status");
            $place->parent = $parent;

            if ($parent == 0) {
                $place->rules(
                    ['code' => 'required|unique:places,code,' . $id . ',id,parent,0'],
                    [],
                    ['code' => trans('i18n::places.attributes.code')]
                );
            }

            // fire saving action

            Action::fire("place.saving", $place);

            if (!$place->validate()) {
                return Redirect::back()->withErrors($place->errors())->withInput(Request::all());
            }

            $place->save();

            // fire saved action

            Action::fire("place.saved", $place);

            return Redirect::route("admin.places.edit", array("id" => $id, "parent" => $parent))
                ->with("message", trans("i18n::places.events.updated"));
        }

        $this->data["place"] = $place;
        $this->data["country"] = Place::find($parent);

        return View::make("i18n::places.edit", $this->data);
    }

    /*
     * Delete place by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $ID) {

            $place = Place::findOrFail((int)$ID);

            // Fire deleting action

            Action::fire("place.deleting", $place);

            $place->delete();

            // Fire deleted action

            Action::fire("place.deleted", $place);
        }

        return Redirect::back()->with("message", trans("i18n::places.events.deleted"));
    }

    /*
    * Activating / Deactivating post by id
    * @param $status
    * @return mixed
    */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $place = Place::findOrFail($id);

            // Fire saving action
            Action::fire("place.saving", $place);

            $place->status = $status;
            $place->save();

            // Fire saved action

            Action::fire("place.saved", $place);
        }

        if ($status) {
            $message = trans("i18n::places.events.activated");
        } else {
            $message = trans("i18n::places.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /*
     * Rest service to search places
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $places = Place::search($q)->get()->toArray();

        return json_encode($places);
    }
}
