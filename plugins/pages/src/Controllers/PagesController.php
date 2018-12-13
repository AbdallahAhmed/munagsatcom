<?php

namespace Dot\Pages\Controllers;

use Action;
use Illuminate\Support\Facades\Auth;
use Dot\Pages\Models\Page;
use Dot\Platform\Controller;
use Redirect;
use Request;
use View;

/*
 * Class PagesController
 * @package Dot\Pages\Controllers
 */
class PagesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all pages
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

        $query = Page::with('image', 'user', 'tags')->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("tag_id")) {
            $query->whereHas("tags", function ($query) {
                $query->where("tags.id", Request::get("tag_id"));
            });
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

        $this->data["pages"] = $query->paginate($this->data['per_page']);

        return View::make("pages::show", $this->data);
    }

    /*
     * Delete page by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $ID) {

            $page = Page::findOrFail($ID);

            // Fire deleting action

            Action::fire("page.deleting", $page);

            $page->tags()->detach();
            $page->delete();

            // Fire deleted action

            Action::fire("page.deleted", $page);
        }

        return Redirect::back()->with("message", trans("pages::pages.events.deleted"));
    }

    /*
     * Activating / Deactivating page by id
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $page = Page::findOrFail($id);

            // Fire saving action

            Action::fire("page.saving", $page);

            $page->status = $status;
            $page->save();

            // Fire saved action

            Action::fire("page.saved", $page);
        }

        if ($status) {
            $message = trans("pages::pages.events.activated");
        } else {
            $message = trans("pages::pages.events.deactivated");
        }

        return Redirect::back()->with("message", $message);
    }

    /*
     * Create a new page
     * @return mixed
     */
    public function create()
    {

        $page = new Page();

        if (Request::isMethod("post")) {

            $page->title = Request::get('title');
            $page->slug = Request::get('slug');
            $page->excerpt = Request::get('excerpt');
            $page->content = Request::get('content');
            $page->image_id = Request::get('image_id');
            $page->user_id = Auth::user()->id;
            $page->status = Request::get("status", 0);
            $page->lang = app()->getLocale();

            // Fire saving action

            Action::fire("page.saving", $page);

            if (!$page->validate()) {
                return Redirect::back()->withErrors($page->errors())->withInput(Request::all());
            }

            $page->save();
            $page->syncTags(Request::get("tags"));

            // Fire saved action

            Action::fire("page.saved", $page);

            return Redirect::route("admin.pages.edit", array("id" => $page->id))
                ->with("message", trans("pages::pages.events.created"));
        }

        $this->data["page_tags"] = array();
        $this->data["page"] = $page;

        return View::make("pages::edit", $this->data);
    }

    /*
     * Edit page by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $page = Page::findOrFail($id);

        if (Request::isMethod("post")) {

            $page->slug = Request::get('slug');
            $page->title = Request::get('title');
            $page->excerpt = Request::get('excerpt');
            $page->content = Request::get('content');
            $page->image_id = Request::get('image_id');
            $page->status = Request::get("status", 0);
            $page->lang = app()->getLocale();

            // Fire saving action

            Action::fire("page.saving", $page);

            if (!$page->validate()) {
                return Redirect::back()->withErrors($page->errors())->withInput(Request::all());
            }

            $page->save();
            $page->syncTags(Request::get("tags"));

            // Fire saved action

            Action::fire("page.saved", $page);

            return Redirect::route("admin.pages.edit", array("id" => $id))->with("message", trans("pages::pages.events.updated"));
        }

        $this->data["page_tags"] = $page->tags->pluck("name")->toArray();
        $this->data["page"] = $page;

        return View::make("pages::edit", $this->data);
    }

}
