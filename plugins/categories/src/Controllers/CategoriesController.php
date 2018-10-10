<?php

namespace Dot\Categories\Controllers;

use Action;
use Dot\Categories\Models\Category;
use Dot\Platform\Controller;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Request;

class CategoriesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all categories
     * @param int $parent
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

        $this->data["sort"] = (Request::filled("sort")) ? Request::get("sort") : "name";
        $this->data["order"] = (Request::filled("order")) ? Request::get("order") : "ASC";
        $this->data['per_page'] = (Request::filled("per_page")) ? Request::get("per_page") : NULL;

        $query = Category::parent($parent)->orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(urldecode(Request::get("q")));
        }

        $this->data["categories"] = $query->paginate($this->data['per_page']);

        return view("categories::show", $this->data);
    }

    /*
     * Delete category by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $category = Category::findOrFail($id);

            // Fire deleting action

            Action::fire("category.deleting", $category);

            $category->delete();

            // Fire deleted action

            Action::fire("category.deleted", $category);
        }

        return Redirect::back()->with("message", trans("categories::categories.events.deleted"));
    }

    /*
     * Create a new category
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $category = new Category();

            $category->name = Request::get('name');
            $category->slug = Request::get('slug');
            $category->image_id = Request::get('image_id');
            $category->parent = Request::get('parent');
            $category->user_id = Auth::user()->id;
            $category->status = 1;
            $category->lang = app()->getLocale();

            // Fire saving action

            Action::fire("category.saving", $category);

            if (!$category->validate()) {
                return Redirect::back()->withErrors($category->errors())->withInput(Request::all());
            }

            $category->save();

            // Fire saved action

            Action::fire("category.saved", $category);

            return Redirect::route("admin.categories.edit", array("id" => $category->id))
                ->with("message", trans("categories::categories.events.created"));
        }

        $this->data["category"] = false;

        return view("categories::edit", $this->data);
    }

    /*
     * Edit category by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $category = Category::findOrFail($id);

        if (Request::isMethod("post")) {

            $category->name = Request::get('name');
            $category->slug = Request::get('slug');
            $category->image_id = Request::get('image_id');
            $category->parent = Request::get('parent');
            $category->status = 1;
            $category->lang = app()->getLocale();

            // Fire saving action

            Action::fire("category.saving", $category);

            if (!$category->validate()) {
                return Redirect::back()->withErrors($category->errors())->withInput(Request::all());
            }

            $category->save();

            // Fire saved action

            Action::fire("category.saved", $category);

            return Redirect::route("admin.categories.edit", array("id" => $id))->with("message", trans("categories::categories.events.updated"));
        }

        $this->data["category"] = $category;

        return view("categories::edit", $this->data);
    }

}
