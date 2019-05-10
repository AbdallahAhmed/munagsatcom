<?php

namespace Dot\Services\Controllers;

use Action;
use Dot\Options\Facades\Option;
use Dot\Services\Models\Service;
use Dot\Platform\Controller;
use Illuminate\Support\MessageBag;
use Redirect;
use Request;
use View;

/*
 * Class ServicesController
 * @package Dot\Services\Controllers
 */

class PointsController extends Controller
{

    /*
     * View payload
     * @var array
     */
    protected $data = [];
    protected $errors;

    public function index()
    {

        if (Request::isMethod("post")) {
            $this->errors = new MessageBag();
            if (Request::get("option")["rules_book_percentage"] > 100 or Request::get("option")["rules_book_percentage"] < 0) {
                $this->errors->add("percentage", trans("rules_book_percentage_error"));
            }
            if ($this->errors->isNotEmpty())
                return Redirect::back()->withErrors($this->errors)->withInput(Request::all());

            foreach (Request::get("option") as $name => $value) {
                Option::set($name, $value);
            }

        }
        $this->data['rules_book_percentage'] = option("rules_book_percentage");
        $this->data['rules_add_chances'] = option("rules_add_chances",0);
        $this->data['service_center_add'] = option("service_center_add");
        $this->data['point_per_reyal'] = option("point_per_reyal");
        $this->data['new_user_points'] = option("new_user_points", 0);
        $this->data['points_tax'] = option("points_tax", 5);
        return view("services::points", $this->data);
    }

}
