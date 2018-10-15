<?php

namespace Dot\Tenders\Controllers;

use Action;
use Illuminate\Support\Facades\Auth;
use Dot\Platform\Controller;
use Dot\Tenders\Models\TenderOrg;
use Redirect;
use Request;
use View;


/**
 * Class TenderOrgController
 * @package Dot\Tender\Controllers
 */
class TenderOrgController extends Controller
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

        $query = TenderOrg::with( 'user')->orderBy($this->data["sort"], $this->data["order"]);

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


        $this->data["orgs"] = $query->paginate($this->data['per_page']);

        return View::make("tenders::orgs.show", $this->data);
    }

    /**
     * Delete org by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $ID) {

            $org = TenderOrg::findOrFail($ID);

            // Fire deleting action

            Action::fire("org.deleting", $org);


            $org->delete();

            // Fire deleted action

            Action::fire("org.deleted", $org);
        }

        return Redirect::back()->with("message", trans("tenders::orgs.events.deleted"));
    }

    /**
     * Activating / Deactivating org by id
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $org = TenderOrg::findOrFail($id);

            // Fire saving action
            Action::fire("org.saving", $org);

            $org->status = $status;
            $org->save();

            // Fire saved action

            Action::fire("org.saved", $org);
        }

        if ($status) {
            $message = trans("tenders::orgs.events.activated");
        } else {
            $message = trans("tenders::orgs.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /**
     * Create a new org
     * @return mixed
     */
    public function create()
    {

        $org = new TenderOrg();

        if (Request::isMethod("post")) {

            $org->name = Request::get('name');
            $org->status = Request::get('status',0);
            $org->logo_id = Request::get('logo_id',0);

            $org->user_id = Auth::user()->id;
            // Fire saving action

            Action::fire("org.saving", $org);

            if (!$org->validate()) {
                return Redirect::back()->withErrors($org->errors())->withInput(Request::all());
            }

            $org->save();
            // Fire saved action

            Action::fire("org.saved", $org);

            return Redirect::route("admin.tenders.orgs.edit", array("id" => $org->id))
                ->with("message", trans("tenders::orgs.events.created"));
        }
        $this->data["org"] = $org;

        return View::make("tenders::orgs.edit", $this->data);
    }

    /**
     * Edit org by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $org = TenderOrg::findOrFail($id);

        if (Request::isMethod("post")) {

            $org->name = Request::get('name');
            $org->status = Request::get('status',0);
            $org->logo_id = Request::get('logo_id',0);

            // Fire saving action

            Action::fire("org.saving", $org);

            if (!$org->validate()) {
                return Redirect::back()->withErrors($org->errors())->withInput(Request::all());
            }

            $org->save();

            // Fire saved action

            Action::fire("org.saved", $org);

            return Redirect::route("admin.tenders.orgs.edit", array("id" => $id))->with("message", trans("tenders::orgs.events.updated"));
        }


        $this->data["org"] = $org;
        return View::make("tenders::orgs.edit", $this->data);
    }

}
