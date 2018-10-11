<?php

namespace Dot\Chances\Controllers;

use Action;
use Dot\Blocks\Models\Block;
use Dot\Chances\Models\Chance;
use Dot\Platform\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Redirect;
use Request;
use View;

/*
 * Class ChancesController
 * @package Dot\Chances\Controllers
 */

class ChancesController extends Controller
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

        return View::make("chances::show", $this->data);
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

        return Redirect::back()->with("message", trans("chances::chances.events.deleted"));
    }

    /*
     * Create a new block
     * @return mixed
     */
    public function create()
    {

        if (Request::isMethod("post")) {

            $chance = new Chance();

            $chance->name = "ss";//Request::get("name");
            $chance->number = "ss";//Request::get("number");
            $chance->closing_date = Carbon::createFromFormat('Y-m-d\TH:i',Request::get("closing_date"));
            $chance->file_name = "ss";//Request::get("file_name");
            $chance->file_description = "Ss";//Request::get("file_description");
            $chance->status = Request::get("status", 0);
            $chance->approved = "SS";//Request::get('approved');
            $chance->reason = Request::get("reason", "");
            $chance->user_id = Auth::user()->id;
            $chance->media_id = "0";//Request::get("media_id");
            $units = Request::get("units", []);
            $units_names = Request::get("units_names", []);
            $sectors = Request::get("sectors", []);
die(Carbon::createFromFormat('Y-m-d\TH:i',Request::get("closing_date")));
$chance->save();
            $errors = new MessageBag();

            if (!$units)
                $errors->add("units", trans("chances::chances.attributes.units") . " " . trans("chances::chances.required") . ".");
            if (!$sectors)
                $errors->add("sectors", trans("chances::chances.attributes.sectors") . " " . trans("chances::chances.required") . ".");
            if (!$units_names)
                $errors->add("units_names", trans("chances::chances.attributes.units_names") . " " . trans("chances::chances.required") . ".");

            if (!$chance->validate()) {
                $errors->merge($chance->errors());
                return Redirect::back()->withErrors($errors)->withInput(Request::all());
            }
            $chance->save();
            $chance->syncSectors(Request::get("sectors", []));
            $chance->units()->sync(Request::get("units", []), Request::get("sectors_names", []));

            // Fire saved action

            Action::fire("chance.saved", $chance);

            return Redirect::route("admin.chances.edit", array("id" => $chance->id))
                ->with("message", trans("chances::chances.events.created"));
        }

        $this->data["chance"] = Chance::find(1);
        $this->data["block_tags"] = array();
        $this->data["block_categories"] = collect([]);

        return View::make("chances::edit", $this->data);
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

            return Redirect::route("admin.chances.edit", array("id" => $id))->with("message", trans("chances::chances.events.updated"));
        }

        $this->data["block"] = $block;
        $this->data["block_tags"] = $block->tags->pluck("name")->toArray();
        $this->data["block_categories"] = $block->categories;

        return View::make("chances::edit", $this->data);
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
