<?php

namespace Dot\Blocks\Controllers;

use Action;
use Dot\Blocks\Models\Block;
use Dot\Platform\Controller;
use Redirect;
use Request;
use View;

/*
 * Class BlocksController
 * @package Dot\Blocks\Controllers
 */
class BlocksController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /*
     * Show all blocks
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

        $query = Block::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(Request::get("q"));
        }

        $blocks = $query->paginate($this->data['per_page']);

        $this->data["blocks"] = $blocks;

        return View::make("blocks::show", $this->data);
    }

    /*
     * Delete block by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $block = Block::findOrFail($id);

            // Fire deleting action

            Action::fire("block.deleting", $block);

            $block->delete();
            $block->tags()->detach();
            $block->categories()->detach();

            // Fire deleted action

            Action::fire("block.deleted", $block);
        }

        return Redirect::back()->with("message", trans("blocks::blocks.events.deleted"));
    }

    /*
     * Create a new block
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $block = new Block();

            $block->name = Request::get("name");
            $block->type = Request::get("type");
            $block->limit = Request::get("limit", 0);
            $block->lang = app()->getLocale();

            // Fire Saving block

            Action::fire("block.saving", $block);

            if (!$block->validate()) {
                return Redirect::back()->withErrors($block->errors())->withInput(Request::all());
            }

            $block->save();
            $block->syncTags(Request::get("tags", []));
            $block->categories()->sync(Request::get("categories", []));

            // Fire saved action

            Action::fire("block.saved", $block);

            return Redirect::route("admin.blocks.edit", array("id" => $block->id))
                ->with("message", trans("blocks::blocks.events.created"));
        }

        $this->data["block"] = false;
        $this->data["block_tags"] = array();
        $this->data["block_categories"] = collect([]);

        return View::make("blocks::edit", $this->data);
    }

    /*
     * Edit block by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $block = Block::findOrFail($id);

        if (Request::isMethod("post")) {

            $block->name = Request::get("name");
            $block->type = Request::get("type");
            $block->limit = Request::get("limit", 0);
            $block->lang = app()->getLocale();

            // Fire saving action

            Action::fire("block.saving", $block);

            if (!$block->validate()) {
                return Redirect::back()->withErrors($block->errors())->withInput(Request::all());
            }

            $block->save();
            $block->syncTags(Request::get("tags", []));
            $block->categories()->sync(Request::get("categories", []));

            // Fire saved action

            Action::fire("block.saved", $block);

            return Redirect::route("admin.blocks.edit", array("id" => $id))->with("message", trans("blocks::blocks.events.updated"));
        }

        $this->data["block"] = $block;
        $this->data["block_tags"] = $block->tags->pluck("name")->toArray();
        $this->data["block_categories"] = $block->categories;

        return View::make("blocks::edit", $this->data);
    }

    /*
     * Rest Service to search blocks
     * @return string
     */
    function search()
    {

        $q = trim(urldecode(Request::get("q")));

        $blocks = Block::search($q)->get()->toArray();

        return json_encode($blocks);
    }
}
