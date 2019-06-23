<?php

namespace Dot\Companies\Controllers;

use Action;
use App\Exports\TransactionExporter;
use App\Mail\CompanyStatusChange;
use App\Models\Transaction;
use Dot\Chances\Models\Sector;
use Dot\Companies\Models\Company;
use Dot\Platform\Classes\Carbon;
use Dot\Platform\Controller;
use Dot\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Request;

class CompaniesController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];

    /**
     * Show all companies
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
            $company->first_name = Request::get('first_name', $company->first_name);
            $company->last_name = Request::get('last_name', $company->last_name);
            $company->details = Request::get('details', "");
            $company->phone_number = Request::get('phone_number', "");
            $company->mobile_number = Request::get('mobile_number', "");
            $company->address = Request::get('address', "");
            $company->blocked = Request::get('blocked', 0);
            if (Request::get('blocked') == 1) {
                $company->block_reason = Request::get('block_reason');
            } else {
                $company->block_reason = null;
            }

            if ($company->status != Request::get('status')) {
                try {
                    Mail::to($company->user->email)->send(new CompanyStatusChange($company, Request::get('status')));
                } catch (\Exception $e) {

                }
            }
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


    /**
     * Show all transactions
     * @param int $parent
     * @return mixed
     */
    function transactions()
    {

        if (!Auth::user()->can("companies.transactions")) {
            abort(404);
        }

        $this->data["sort"] = (Request::filled("sort")) ? Request::get("sort") : "created_at";
        $this->data["order"] = (Request::filled("order")) ? Request::get("order") : "DESC";
        $this->data['per_page'] = (Request::filled("per_page")) ? Request::get("per_page") : NULL;

        $query = Transaction::orderBy($this->data["sort"], $this->data["order"]);

        if (Request::filled('action')) {
            $query->where('action', Request::get('action'));
        }

        if (Request::filled('user_id')) {
            $this->data["user"] = $user = \App\User::findOrFail(Request::get('user_id'));
            $this->data["added_points"] = $user->in_company ? \App\Models\Transaction::where(['company_id' => $user->company[0]->id, 'action' => 'points.buy'])->sum('points')
                : \App\Models\Transaction::where(['user_id' => $user->id, 'action' => 'points.buy'])->sum('points');


            if ($user->in_company) {
                $query->where('company_id', $user->company[0]->id);
            } else {
                $query->where('user_id', request('user_id'));
            }

        }

        if (Request::filled('company_id')) {
            $query->where('company_id', request('company_id'));
            $this->data["user"] = $user = \App\User::findOrFail(\App\Models\Company::findOrFail(request('company_id'))->user_id);
            $this->data["added_points"] = $user->in_company ? \App\Models\Transaction::where(['company_id' => $user->company[0]->id, 'action' => 'points.buy'])->sum('points')
                : \App\Models\Transaction::where(['user_id' => $user->id, 'action' => 'points.buy'])->sum('points');
        }

        if (Request::filled('q')) {
            $query->whereHas('user', function ($query) {
                $query->where('first_name', 'LIKE', '%' . Request::get('q') . '%');
                $query->orWhere('last_name', 'LIKE', '%' . Request::get('q') . '%');
            });

            $query->orWhereHas('user.company', function ($query) {
                $query->where('name', 'LIKE', '%' . request('q') . '%');
            });
        }
        if (Request::filled('to') && Request::filled('from')) {
//            $query->where('created_at', '<=', request('to'));
            $query->whereBetween('created_at', [request('from'), request('to')]);
        }


        $this->data["transactions"] = $query->paginate($this->data['per_page']);

        if (Request::filled('exports')) {
            return Excel::download(new TransactionExporter($this->data["transactions"]), 'transactions.xlsx');
        }
        return view("companies::transactions", $this->data);
    }

    /**
     *
     */
    public function setDataChart($user)
    {
    }

}
