<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    /**
     * GET {lang?}/user/recharge/
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('payments');
    }


    /**
     * POST {lang?}/user/recharge/
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recharge(Request $request)
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
        $points = option('point_per_reyal') * $request->get('price');
        $response = $this->request($request);
        dd($response);

    }

    private function request(Request $request)
    {
        $url = "https://test.oppwa.com/v1/payments";
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }
}
