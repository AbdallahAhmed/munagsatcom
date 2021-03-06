<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\Tender;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenderController extends Controller
{

    /**
     * @var array
     */
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:frontend')->except(['index', 'details']);
    }

    /** GET /{lang?}
     * @route index
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $query = Tender::with(['org', 'org.logo', 'files'])->has('org')->published();

        if ($request->filled('activity_id')) {
            $query->where('activity_id', $request->get('activity_id'));
        }

        if ($request->filled('q')) {
            $query->where('name', 'LIKE', '%' . trim($request->get('q')) . '%');
        }

        if ($request->filled('org_id')) {
            $query->where('org_id', $request->get('org_id'));
        }

        if ($request->filled('offer_expired')) {
            $carbon = new Carbon($request->get('offer_expired'));
            $query->whereDay('last_get_offer_at', '=', $carbon->day);
            $query->whereMonth('last_get_offer_at', '=', $carbon->month);
            $query->whereYear('last_get_offer_at', '=', $carbon->year);
        }

        if ($request->filled('show_expired') && $request->get('show_expired') == 1) {
            $query->orWhere('last_get_offer_at', '<=', Carbon::now());
        }

        if ($request->filled('place_id')) {
            $query->whereHas('places', function ($query) use ($request) {
                return $query->where('id', $request->get('place_id'));
            });
        }

        if ($request->filled('cb_downloaded_price')) {
            $price = explode(',', $request->get('cb_downloaded_price'));
            $query->where('cb_downloaded_price', '>=', min($price));
            $query->where('cb_downloaded_price', '<=', max($price));
        }

        if ($request->filled('cb_real_price')) {

            $price = explode(',', $request->get('cb_real_price'));
            $query->where('cb_real_price', '>=', min($price));
            $query->where('cb_real_price', '<=', max($price));
        }

        if ($request->filled('catgory_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                return $query->where('id', $request->get('catgory_id'));
            });
        }
        $query->where('last_get_offer_at', '>=', Carbon::now());
        $this->data['tenders'] = $query->orderBy('created_at', 'DESC')->paginate(15);

        $this->data['cb_downloaded_price_max'] = Tender::max('cb_downloaded_price');
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
        $this->data['tender'] = Tender::with(['org', 'org.logo', 'activity', 'files'])->has('org')->published()->where('slug', $slug)->first();
        $this->data['tender']->views++;
        $this->data['tender']->save();
        return view('tenders.details', $this->data);
    }


    /**
     * POST {lang?}/tenders/{id}/buycb
     * @route  tenders.buy
     * @param Request $request
     * @param $id
     * @return string
     */
    public function buyCB(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);
        if (!$tender) {
            abort(404);
        }
        $user = fauth()->user();

        if ($user->in_company) {
            $user = $user->company[0];
        }

        if ($tender->is_bought) {
            return 'Can\'t buy this twice.';
        }

        if (!fauth()->user()->can_buy) {
            return 'Can\'t you can buy tenders.';
        }

        $paypoints = tax($tender->points, false);
        if ($paypoints > $user->points) {
            return 'Can\'t buy this you have\'nt points enough.';
        }

        $after_points = $user->points - $paypoints;

        $points = $user->points;

        $user->points = $after_points;
        $user->spent_points = $user->spent_points + $paypoints;
        $user->save();


        Transaction::create([
            'before_points' => $points,
            'after_points' => $after_points,
            'points' => $paypoints,
            'object_id' => $tender->id,
            'tax' => tax($tender->points),
            'user_id' => fauth()->id(),
            'action' => 'tenders.buy',
            'company_id' => fauth()->user()->in_company ? $user->id : 0
        ]);

        // notification for user
        $notif_data = array();
        $notif_data['tender_id'] = $tender->id;
        $notification = new Notifications();
        $notification->user_id = $user->id;
        $notification->key = "tender.bought";
        $notification->data = json_encode($notif_data);
        $notification->save();

        //notification for owner
        $notif_data = array();
        $notif_data['buyer_id'] = $user->id;
        $notif_data['tender_id'] = $tender->id;
        $notification = new Notifications();
        $notification->user_id = $tender->user_id;
        $notification->key = "to.company.tender.bought";
        $notification->data = json_encode($notif_data);
        $notification->save();

        $tender->buyers()->attach(fauth()->id(), ['points' => $tender->points]);

        $tender->downloaded++;
        $tender->save();

        return redirect()->back()->with('download', route('tenders.download', ['id' => $tender->id, 'lang' => app()->getLocale()]));
    }


    /**
     * GET {lang?}/tenders/{id}/download
     * @route tenders.download
     * @param Request $request
     * @param $id
     * @return string
     */
    public function download(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);
        if (!$tender) {
            abort(404);
        }

        if (!$tender->is_bought) {
            abort(404);
        }

        if (!($tender->cb && file_exists(uploads_path($tender->cb->path)))) {
            return 'كراسة الشروط تم مسحها';
        }

        return response()->download(uploads_path($tender->cb->path), $tender->name . '.' . pathinfo($tender->cb->path, PATHINFO_EXTENSION), ['Content-Type: application/pdf']);
    }
}
