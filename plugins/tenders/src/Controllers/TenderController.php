<?php

namespace Dot\Tenders\Controllers;

use Action;
use App\Imports\TenderImport;
use Dot\I18n\Models\Place;
use Dot\Media\Models\Media;
use Illuminate\Support\Facades\Auth;
use Dot\Platform\Controller;
use Dot\Tenders\Models\Tender;
use Maatwebsite\Excel\Importer;
use Redirect;
use Request;
use View;


/**
 * Class TendersController
 * @package Dot\Tenders\Controllers
 */
class TenderController extends Controller
{

    /**
     * View payload
     * @var array
     */
    protected $data = [];


    private $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * Show all posts
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

        $query = Tender::with('user')->orderBy($this->data["sort"], $this->data["order"]);


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

        $this->data["tenders"] = $query->paginate($this->data['per_page']);

        return View::make("tenders::show", $this->data);
    }

    /**
     * Delete tender by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $ID) {

            $tender = Tender::findOrFail($ID);

            // Fire deleting action

            Action::fire("tender.deleting", $tender);

            $tender->categories()->detach();
            $tender->places()->detach();

            $tender->delete();

            // Fire deleted action

            Action::fire("tender.deleted", $tender);
        }

        return Redirect::back()->with("message", trans("tenders::tenders.events.deleted"));
    }

    /**
     * Activating / Deactivating post by id
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $tender = Tender::findOrFail($id);

            // Fire saving action
            Action::fire("tender.saving", $tender);

            $tender->status = $status;
            $tender->save();

            // Fire saved action

            Action::fire("tender.saved", $tender);
        }

        if ($status) {
            $message = trans("tenders::tenders.events.activated");
        } else {
            $message = trans("tenders::tenders.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /**
     * Create a new post
     * @return mixed
     */
    public function create()
    {

        $tender = new Tender();

        if (Request::isMethod("post")) {

            $tender->name = Request::get('name');
            $tender->objective = Request::get('objective');

            $tender->address_get_offer = Request::get('address_get_offer');
            $tender->address_files_open = Request::get('address_files_open');
            $tender->address_execute = Request::get('address_execute');
            $tender->is_cb_ratio_active = Request::get("is_cb_ratio_active", 0);


            $tender->cb_real_price = Request::get('cb_real_price');

            // wait for setting
            if (!$tender->is_cb_ratio_active) {
                $tender->cb_downloaded_price = Request::get('cb_downloaded_price');
            } else {
                $tender->cb_downloaded_price = ((float)((option("rules_book_percentage", 1)) / 100.0)) * $tender->cb_real_price;
            }

            $tender->org_id = Request::get('org_id', 0);
            $tender->cb_id = Request::get('cb_id', 0);
            $tender->type_id = Request::get('type_id', 0);
            $tender->activity_id = Request::get('activity_id', 0);


            $tender->user_id = Auth::user()->id;

            $tender->status = Request::get("status", 0);
            $tender->price = Request::get("price", 0);
            $tender->number = Request::get("number", 0);

            //dates
            $tender->published_at = Request::get('published_at', date("Y-m-d H:i:s"));
            $tender->last_queries_at = Request::get('last_queries_at', date("Y-m-d H:i:s"));
            $tender->last_get_offer_at = Request::get('last_get_offer_at', date("Y-m-d H:i:s"));
            $tender->files_opened_at = Request::get('files_opened_at', date("Y-m-d H:i:s"));
            // Fire saving action

            Action::fire("tender.saving", $tender);

            if (!$tender->validate()) {
                return Redirect::back()->withErrors($tender->errors())->withInput(Request::all());
            }

            $tender->save();

            $tender->categories()->sync(Request::get("categories", []));
            $tender->places()->sync(Request::get("tender_places", []));
            $tender->files()->sync(Request::get("files", []));


            // Fire saved action

            Action::fire("tender.saved", $tender);

            return Redirect::route("admin.tenders.edit", array("id" => $tender->id))
                ->with("message", trans("tenders::tenders.events.created"));
        }

        $this->data["tender_categories"] = collect([]);
        $this->data["files"] = $tender->files;
        $this->data["tender"] = $tender;

        return View::make("tenders::edit", $this->data);
    }

    /**
     * Edit post by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $tender = Tender::findOrFail($id);
        if (Request::isMethod("post")) {


            $tender->name = Request::get('name');
            $tender->objective = Request::get('objective');

            $tender->address_get_offer = Request::get('address_get_offer');
            $tender->address_files_open = Request::get('address_files_open');
            $tender->address_execute = Request::get('address_execute');
            $tender->is_cb_ratio_active = Request::get("is_cb_ratio_active", 0);
            $tender->price = Request::get("price", 0);

            $tender->cb_real_price = Request::get('cb_real_price');

            // wait for setting
            if (!$tender->is_cb_ratio_active) {
                $tender->cb_downloaded_price = Request::get('cb_downloaded_price');
            } else {
                $tender->cb_downloaded_price = ((float)((option("rules_book_percentage", 1)) / 100.0)) * $tender->cb_real_price;
            }

            $tender->org_id = Request::get('org_id', 0);
            $tender->cb_id = Request::get('cb_id', 0);
            $tender->type_id = Request::get('type_id', 0);
            $tender->activity_id = Request::get('activity_id', 0);
            $tender->number = Request::get("number", 0);

            $tender->status = Request::get("status", $tender->status);

            //dates
            $tender->published_at = Request::get('published_at', date("Y-m-d H:i:s"));
            $tender->last_queries_at = Request::get('last_queries_at', date("Y-m-d H:i:s"));
            $tender->last_get_offer_at = Request::get('last_get_offer_at', date("Y-m-d H:i:s"));
            $tender->files_opened_at = Request::get('files_opened_at', date("Y-m-d H:i:s"));
            // Fire saving action

            Action::fire("tender.saving", $tender);

            if (!$tender->validate()) {
                return Redirect::back()->withErrors($tender->errors())->withInput(Request::all());
            }

            $tender->save();
            $tender->categories()->sync(Request::get("categories", []));
            $tender->files()->sync(Request::get("files", []));
            $tender->places()->sync(Request::get("tender_places", []));


            // Fire saved action

            Action::fire("tender.saved", $tender);

            return Redirect::route("admin.tenders.edit", array("id" => $id))->with("message", trans("tenders::tenders.events.updated"));
        }

        $this->data["tender_categories"] = $tender->categories;
        $this->data["files"] = $tender->files;
        $this->data["tender"] = $tender;

        return View::make("tenders::edit", $this->data);
    }

    /**
     * Rest service to search places
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $places = Place::search($q)->where('status', 1)->get()->toArray();

        return json_encode($places);
    }

    /**
     *
     */
    public function import()
    {
        if (Request::isMethod("post")) {
            $media = (new  Media())->saveFile(Request::file('file'));
            $logs = "dsadasdas";
            $this->importer->import(new TenderImport($logs), uploads_path(Media::find($media)->path));
            dd($logs);
        }
        return view('tenders::import');
    }


}
