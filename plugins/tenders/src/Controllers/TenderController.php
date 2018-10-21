<?php

namespace Dot\Tenders\Controllers;

use Action;
use Illuminate\Support\Facades\Auth;
use Dot\Platform\Controller;
use Dot\Tenders\Models\Tender;
use Dot\Tenders\Models\TenderMeta;
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

            $tender->tags()->detach();
            $tender->categories()->detach();
            $tender->galleries()->detach();
            $tender->blocks()->detach();

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

            $tender->title = Request::get('title');
            $tender->excerpt = Request::get('excerpt');
            $tender->content = Request::get('content');
            $tender->image_id = Request::get('image_id', 0);
            $tender->media_id = Request::get('media_id', 0);
            $tender->user_id = Auth::user()->id;
            $tender->status = Request::get("status", 0);
            $tender->format = Request::get("format", "post");
            $tender->lang = app()->getLocale();

            $tender->published_at = Request::get('published_at');

            if (in_array($tender->published_at, [NULL, ""])) {
                $tender->published_at = date("Y-m-d H:i:s");
            }

            // Fire saving action

            Action::fire("tender.saving", $tender);

            if (!$tender->validate()) {
                return Redirect::back()->withErrors($tender->errors())->withInput(Request::all());
            }

            $tender->save();
            $tender->syncTags(Request::get("tags", []));
            $tender->categories()->sync(Request::get("categories", []));
            $tender->galleries()->sync(Request::get("galleries", []));
            $tender->syncBlocks(Request::get("blocks", []));

            // Saving post meta

            $custom_fields = array_filter(array_combine(Request::get("custom_names", []), Request::get("custom_values", [])));

            foreach ($custom_fields as $name => $value) {
                $meta = new TenderMeta();
                $meta->name = $name;
                $meta->value = $value;
                $tender->meta()->save($meta);
            }

            // Fire saved action

            Action::fire("tender.saved", $tender);

            return Redirect::route("admin.posts.edit", array("id" => $tender->id))
                ->with("message", trans("tenders::tenders.events.created"));
        }

        $this->data["post_tags"] = array();
        $this->data["post_categories"] = collect([]);
        $this->data["post_galleries"] = collect([]);
        $this->data["post_blocks"] = collect([]);
        $this->data["post"] = $tender;

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

            $tender->title = Request::get('title');
            $tender->excerpt = Request::get('excerpt');
            $tender->content = Request::get('content');
            $tender->image_id = Request::get('image_id', 0);
            $tender->media_id = Request::get('media_id', 0);
            $tender->status = Request::get("status", 0);
            $tender->format = Request::get("format", "post");
            $tender->published_at = Request::get('published_at') != "" ? Request::get('published_at') : date("Y-m-d H:i:s");
            $tender->lang = app()->getLocale();

            // Fire saving action

            Action::fire("tender.saving", $tender);

            if (!$tender->validate()) {
                return Redirect::back()->withErrors($tender->errors())->withInput(Request::all());
            }

            $tender->save();
            $tender->categories()->sync(Request::get("categories", []));
            $tender->galleries()->sync(Request::get("galleries", []));
            $tender->syncTags(Request::get("tags", []));
            $tender->syncBlocks(Request::get("blocks", []));

            // Fire saved action

            TenderMeta::where("post_id", $tender->id)->delete();

            $custom_fields = array_filter(array_combine(Request::get("custom_names", []), Request::get("custom_values", [])));

            foreach ($custom_fields as $name => $value) {
                $meta = new TenderMeta();
                $meta->name = $name;
                $meta->value = $value;
                $tender->meta()->save($meta);
            }

            // Fire saved action

            Action::fire("tender.saved", $tender);

            return Redirect::route("admin.posts.edit", array("id" => $id))->with("message", trans("tenders::tenders.events.updated"));
        }

        $this->data["post_tags"] = $tender->tags->pluck("name")->toArray();
        $this->data["post_categories"] = $tender->categories;
        $this->data["post_galleries"] = $tender->galleries;
        $this->data["post_blocks"] = $tender->blocks;
        $this->data["post"] = $tender;

        return View::make("tenders::edit", $this->data);
    }

}
