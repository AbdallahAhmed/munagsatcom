<?php

namespace Dot\Services\Controllers;

use Action;
use Dot\Services\Models\Service;
use Dot\Platform\Controller;
use Redirect;
use Request;
use View;

/*
 * Class ServicesController
 * @package Dot\Services\Controllers
 */
class ServicesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all services
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

        $query = Service::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $services = $query->paginate($this->data['per_page']);

        $this->data["services"] = $services;

        return View::make("services::show", $this->data);
    }

    /*
     * Delete service by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {
            $block = Service::findOrFail($id);
            $block->delete();
        }

        return Redirect::back()->with("message", trans("services::services.events.deleted"));
    }

    /*
     * Create a new service
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $service = new Service();

            $service->name = Request::get("name");
            $service->status = Request::get("status", 0);


            if (!$service->validate()) {
                return Redirect::back()->withErrors($service->errors())->withInput(Request::all());
            }

            $service->save();

            return Redirect::route("admin.services.edit", array("id" => $service->id))
                ->with("message", trans("services::services.events.created"));
        }

        $this->data["service"] = false;

        return View::make("services::edit", $this->data);
    }

    /*
     * Edit service by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $service = Service::findOrFail($id);

        if (Request::isMethod("post")) {

            $service->name = Request::get("name");
            $service->details = Request::get("details");
            $service->price_from = Request::get("price_from");
            $service->price_to = Request::get("price_to");
            $service->status = Request::get("status", 0);



            if (!$service->validate()) {
                return Redirect::back()->withErrors($service->errors())->withInput(Request::all());
            }

            $service->save();

            return Redirect::route("admin.services.edit", array("id" => $id))->with("message", trans("services::services.events.updated"));
        }

        $this->data["service"] = $service;

        return View::make("services::edit", $this->data);
    }


    /**
     * Activating / Deactivating service by id
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $service = Service::findOrFail($id);
            $service->status = $status;
            $service->save();
        }

        if ($status) {
            $message = trans("services::services.events.activated");
        } else {
            $message = trans("services::services.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /*
     * Rest Service to search services
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $service = Service::search($q)->get()->toArray();

        return json_encode($service);
    }
}
