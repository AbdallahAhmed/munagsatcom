<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public $baseUrl = 'https://test.oppwa.com/v1';

    public $params = '';
    //

    /**
     * GET {lang?}/user/recharge/
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('payments-cppy');
    }


    /**
     * POST {lang?}/user/recharge/
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recharge(Request $request)
    {

        $url = "$this->baseUrl/checkouts";
        $data = "authentication.userId=8ac7a4ca68ccb1470169008d5a4f484e" .
            "&authentication.password=kGSpEA3QJd" .
            "&authentication.entityId=8ac7a4ca68ccb1470169008ebbdb4853" .
            "&amount=" . $request->get('price') .
            "&currency=SAR" .
            "&paymentType=DB&$this->params";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !env('APP_DEBUG'));// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
//        dd($responseData);
        return view('payments-cppy-step-2', ['result' => json_decode($responseData), 'base_url' => $this->baseUrl]);
    }


    /**
     * GET {lang?}/user/checkout/
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        $url = "$this->baseUrl/checkouts/" . $request->get('id') . "/payment";
        $url .= "?authentication.userId=8ac7a4ca68ccb1470169008d5a4f484e" .
            "&authentication.password=kGSpEA3QJd" .
            "&authentication.entityId=8ac7a4ca68ccb1470169008ebbdb4853";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !env('APP_DEBUG'));// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($responseData);

        if (!empty($result->amount)) {
            $user = fauth()->user();

            if ($user->in_company) {
                $user = $user->company[0];
            }
            $before_points = $user->points;
            $points = (int)($result->amount * (int)option('point_per_reyal'));

            $user->points = $user->points + $points;
            $user->save();
            Transaction::create([
                'before_points' => $before_points,
                'after_points' => $before_points + $points,
                'points' => $points,
                'object_id' => 0,
                'user_id' => fauth()->id(),
                'action' => 'points.buy',
                'company_id' => fauth()->user()->in_company ? $user->id : 0
            ]);
        }
        return redirect()->route('user.points')->with(['messages' => [trans('app.done_recharge_points') . ' ' . ($points ?? '0') . ' ' . trans('app.point')], 'status' => 'success']);
    }


    private function request(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'price' => 'required|numeric',
            'brand' => 'required|in:VISA,MASTER',
            'name_on_card' => 'required',
            'card_number' => 'required|min:10',
            'cvc' => 'required|numeric',
            'month' => 'required|max:2',
            'year' => 'required|size:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $url = "$this->baseUrl/payments";
        $data = "authentication.userId=8ac7a4ca68ccb1470169008d5a4f484e" .
            "&authentication.password=kGSpEA3QJd" .
            "&authentication.entityId=8ac7a4ca68ccb1470169008ebbdb4853" .
            "&amount=" . $request->get('price') .
            "&currency=SAR" .
            "&paymentBrand=" . $request->get('brand') .
            "&paymentType=DB" .
            "&card.number=" . trim($request->get('card_number')) .
            "&card.holder=" . $request->get('name_on_card') .
            "&card.expiryMonth=" . trim($request->get('month')) .
            "&card.expiryYear=" . trim($request->get('year')) .
            "&card.cvv=" . trim($request->get('cvc'));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !env('APP_DEBUG'));// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }
}
