<?php

namespace Dot\Tenders\Controllers;

use Action;
use Illuminate\Support\Facades\Auth;
use Dot\Platform\Controller;
use Dot\Tenders\Models\TenderType;
use Redirect;
use Request;
use View;


/**
 * Class TenderTypeController
 * @package Dot\TenderTypes\Controllers
 */
class TenderTypeController extends Controller
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

        if (Request::isMethod("type")) {
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

        $query = TenderType::with( 'user')->orderBy($this->data["sort"], $this->data["order"]);

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


        $this->data["types"] = $query->paginate($this->data['per_page']);

        return View::make("tenders::types.show", $this->data);
    }

    /**
     * Delete type by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $ID) {

            $type = TenderType::findOrFail($ID);

            // Fire deleting action

            Action::fire("type.deleting", $type);


            $type->delete();

            // Fire deleted action

            Action::fire("type.deleted", $type);
        }

        return Redirect::back()->with("message", trans("tenders::types.events.deleted"));
    }

    /**
     * Activating / Deactivating type by id
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $type = TenderType::findOrFail($id);

            // Fire saving action
            Action::fire("type.saving", $type);

            $type->status = $status;
            $type->save();

            // Fire saved action

            Action::fire("type.saved", $type);
        }

        if ($status) {
            $message = trans("tenders::types.events.activated");
        } else {
            $message = trans("tenders::types.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /**
     * Create a new type
     * @return mixed
     */
    public function create()
    {

        $type = new TenderType();

        if (Request::isMethod("post")) {

            $type->name = Request::get('name');
            $type->status = Request::get('status',0);

            $type->user_id = Auth::user()->id;
            // Fire saving action

            Action::fire("type.saving", $type);

            if (!$type->validate()) {
                return Redirect::back()->withErrors($type->errors())->withInput(Request::all());
            }

            $type->save();
            // Fire saved action

            Action::fire("type.saved", $type);

            return Redirect::route("admin.tenders.types.edit", array("id" => $type->id))
                ->with("message", trans("tenders::types.events.created"));
        }
        $this->data["type"] = $type;

        return View::make("tenders::types.edit", $this->data);
    }

    /**
     * Edit type by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $type = TenderType::findOrFail($id);

        if (Request::isMethod("post")) {

            $type->name = Request::get('name');

            $type->status = Request::get('status',0);

            // Fire saving action

            Action::fire("type.saving", $type);

            if (!$type->validate()) {
                return Redirect::back()->withErrors($type->errors())->withInput(Request::all());
            }

            $type->save();

            // Fire saved action

            Action::fire("type.saved", $type);

            return Redirect::route("admin.tenders.types.edit", array("id" => $id))->with("message", trans("tenders::types.events.updated"));
        }


        $this->data["type"] = $type;
        return View::make("tenders::types.edit", $this->data);
    }

}
