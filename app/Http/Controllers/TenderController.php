<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{

    /**
     * @var array
     */
    public $data = [];

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Tender::with(['org','org.logo'])->published();


        $this->data['tenders'] = $query->orderBy('created_at', 'DESC')->paginate(8);
        return view('tenders.index', $this->data);
    }
}
