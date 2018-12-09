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

    /** GET /{lang?}
     * @route index
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Tender::with(['org', 'org.logo'])->published();

        if ($request->filled('activity_id')) {
            $query->where('activity_id', $request->get('activity_id'));
        }
        if ($request->filled('org_id')) {
            $query->where('org_id', $request->get('org_id'));
        }

        if ($request->filled('offer_expired')) {
            $query->where('last_get_offer_at', '<=', $request->get('offer_expired'));
        }

        if ($request->filled('place_id')) {
            $query->whereHas('places', function ($query) use ($request) {
                return $query->where('id', $request->get('place_id'));
            });
        }

        if ($request->filled('price')) {
            $price = explode(',', $request->get('price'));
            $query->where('price', '>=', $price[0]);
            $query->where('price', '<=', $price[1]);
        }

        if ($request->filled('catgory_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                return $query->where('id', $request->get('catgory_id'));
            });
        }
        $this->data['tenders'] = $query->orderBy('created_at', 'DESC')->paginate(8);
        return view('tenders.index', $this->data);
    }


    /**
     * GET /{lang}/tender/{slug}
     * @route tenders.details
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(Request $request, $slug)
    {
        $this->data['tender'] = Tender::with(['org', 'org.logo', 'activity', 'categories','type'])->published()->where('slug', $slug)->first();
        return view('tenders.details', $this->data);
    }
}