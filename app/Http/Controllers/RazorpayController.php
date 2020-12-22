<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\Order;
use App\Seller;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Input;
use Auth;

class RazorpayController extends Controller
{
    public function payWithRazorpay($request)
    {
        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail(Session::get('order_id'));
                return view('frontend.payWithRazorpay', compact('order'));
            }
            elseif (Session::get('payment_type') == 'seller_payment') {
                $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
                return view('razorpay.payWithRazorpay', compact('seller'));
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                return view('frontend.razor_wallet.payWithRazorpay');
            }
        }

    }

    public function payment()
    {
        //Input items of form
        $input = Input::all();
        //get API Configuration
        if(Session::get('payment_type') == 'cart_payment' || Session::get('payment_type') == 'wallet_payment'){
            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        }
        elseif (Session::get('payment_type') == 'seller_payment') {
            $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
            $api = new Api($seller->razorpay_api_key, $seller->razorpay_secret);
        }

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payment_detalis = json_encode(array('id' => $response['id'],'method' => $response['method'],'amount' => $response['amount'],'currency' => $response['currency']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }

            // Do something here for store payment details in database...
            if(Session::has('payment_type')){
                if(Session::get('payment_type') == 'cart_payment'){
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('order_id'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'seller_payment') {
                    $commissionController = new CommissionController;
                    return $commissionController->seller_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'wallet_payment') {
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), $payment_detalis);
                }
            }
        }
    }
}
