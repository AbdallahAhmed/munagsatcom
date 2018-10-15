<?php

namespace Dot\Tenders\Controllers;

use Action;
use Illuminate\Support\Facades\Auth;
use Dot\Platform\Controller;
use Dot\Tenders\Models\TenderActivity;
use Redirect;
use Request;
use View;


/**
 * Class TenderActivityController
 * @package Dot\Tender\Controllers
 */
class TenderActivityController extends Controller
{

    /**
     * View payload
     * @var array
     */
    protected $data = [];


    /**
     * Show all tenders
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

        $this->data["sort"] = (Request::filled("sort")) ? Request::get("sort") : "created_at";
        $this->data["order"] = (Request::filled("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::filled("per_page")) ? Request::get("per_page") : NULL;

        $query = TenderActivity::with( 'user')->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("tag_id")) {
            $query->whereHas("tags", function ($query) {
                $query->where("tags.id", Request::get("tag_id"));
            });
        }


        if (Request::filled("from")) {
            $query->where("created_at", ">=", Request::get("from"));
        }

        if (Request::filled("to")) {
            $query->where("created_at", "<=", Request::get("to"));
        }

        if (Request::filled("user_id")) {
            $query->whereHas("user", function ($query) {
                $query->where("users.id", Request::get("user_id"));
            });
        }

        if (Request::filled("status")) {
            $query->where("status", Request::get("status"));
        }

        if (Request::filled("q")) {
            $query->search(urldecode(Request::get("q")));
        }


        $this->data["activities"] = $query->paginate($this->data['per_page']);

        return View::make("tenders::activities.show", $this->data);
    }

    /**
     * Delete activity by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $ID) {

            $activity = TenderActivity::findOrFail($ID);

            // Fire deleting action

            Action::fire("activity.deleting", $activity);


            $activity->delete();

            // Fire deleted action

            Action::fire("activity.deleted", $activity);
        }

        return Redirect::back()->with("message", trans("tenders::activities.events.deleted"));
    }

    /**
     * Activating / Deactivating activity by id
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $activity = TenderActivity::findOrFail($id);

            // Fire saving action
            Action::fire("activity.saving", $activity);

            $activity->status = $status;
            $activity->save();

            // Fire saved action

            Action::fire("activity.saved", $activity);
        }

        if ($status) {
            $message = trans("tenders::activities.events.activated");
        } else {
            $message = trans("tenders::activities.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /**
     * Create a new activity
     * @return mixed
     */
    public function create()
    {

        $activity = new TenderActivity();

        if (Request::isMethod("post")) {

            $activity->name = Request::get('name');
            $activity->status = Request::get('status',0);

            $activity->user_id = Auth::user()->id;
            // Fire saving action

            Action::fire("activity.saving", $activity);

            if (!$activity->validate()) {
                return Redirect::back()->withErrors($activity->errors())->withInput(Request::all());
            }

            $activity->save();
            // Fire saved action

            Action::fire("activity.saved", $activity);

            return Redirect::route("admin.tenders.activities.edit", array("id" => $activity->id))
                ->with("message", trans("tenders::activities.events.created"));
        }
        $this->data["activity"] = $activity;

        return View::make("tenders::activities.edit", $this->data);
    }

    /**
     * Edit activity by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $activity = TenderActivity::findOrFail($id);

        if (Request::isMethod("post")) {

            $activity->name = Request::get('name');

            $activity->status = Request::get('status',0);

            // Fire saving action

            Action::fire("activity.saving", $activity);

            if (!$activity->validate()) {
                return Redirect::back()->withErrors($activity->errors())->withInput(Request::all());
            }

            $activity->save();

            // Fire saved action

            Action::fire("activity.saved", $activity);

            return Redirect::route("admin.tenders.activities.edit", array("id" => $id))->with("message", trans("tenders::activities.events.updated"));
        }


        $this->data["activity"] = $activity;
        return View::make("tenders::activities.edit", $this->data);
    }

}
