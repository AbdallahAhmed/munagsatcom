<?php

namespace Dot\Companies\Controllers;

use Action;
use Dot\Chances\Models\Sector;
use Dot\Companies\Models\Company;
use Dot\Platform\Controller;
use Dot\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Request;

class CompaniesController extends Controller
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

        $this->data["sort"] = (Request::filled("sort")) ? Request::get("sort") : "created_at";
        $this->data["order"] = (Request::filled("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::filled("per_page")) ? Request::get("per_page") : NULL;

        $query = Company::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled("q")) {
            $query->search(urldecode(Request::get("q")));
        }

        $this->data["companies"] = $query->paginate($this->data['per_page']);

        return view("companies::show", $this->data);
    }

    /**
     * Delete company by id
     * @return mixed
     */
    public function delete()
    {
        $ids = Request::get("id");

        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {

            $company = Company::findOrFail($id);

            $company->delete();

        }

        return Redirect::back()->with("message", trans("companies::companies.events.deleted"));
    }

    /**
     * Create a new company
     * @return mixed
     */
    public function create()
    {

    }

    /*
     * Edit company by id
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $company = Company::findOrFail($id);

        if (Request::isMethod("post")) {

            $company->name = Request::get('name');
            $company->first_name = Request::get('first_name');
            $company->last_name = Request::get('last_name');
            $company->details = Request::get('details', "");
            $company->phone_number = Request::get('phone_number', "");
            $company->mobile_number = Request::get('mobile_number', "");
            $company->address = Request::get('address', "");
            $company->blocked = Request::get('blocked');
            Request::get('blocked') == 1 ? $company->block_reason = Request::get('block_reason') : $company->block_reason = null;
            $company->status = Request::get('status');
            $company->sector_id = Request::get('sector_id');

            Action::fire("company.saving", $company);

            if (!$company->validate()) {
                return Redirect::back()->withErrors($company->errors())->withInput(Request::all());
            }
            if ($company->status == 1) {
                $company->user()->update(['status' => 1]);
                $company->employees()->update(['users.status' => 1]);
            }
            if ($company->status == 2) {
                $company->user()->update(['status' => 0, 'remember_token' => null]);
                $company->employees()->update(['users.status' => 0, 'remember_token' => null]);
            }
            $company->save();

            return Redirect::route("admin.companies.edit", array("id" => $id))->with("message", trans("companies::companies.events.updated"));
        }

        $this->data["company"] = $company;
        $this->data["files"] = $company->files;
        $this->data['status'] = [0, 1, 2];
        $this->data['sectors'] = Sector::published()->get();

        return view("companies::edit", $this->data);
    }

}
