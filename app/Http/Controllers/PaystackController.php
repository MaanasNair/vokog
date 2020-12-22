<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use App\Seller;
use App\Http\Controllers\Controller;
use Mehedi\Paystack\Paystack;
use Auth;
use Session;
use Redirect;

class PaystackController extends Controller
{
    public function redirectToGateway(Request $request)
    {
        $baseUrl = "https://api.paystack.co";

        if(Session::get('payment_type') == 'cart_payment'){
            $order = Order::findOrFail(Session::get('order_id'));
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round($order->grand_total * 100);
            //$request->key = env('PAYSTACK_SECRET_KEY');
            $request->reference = $paystack->genTranxRef();
            return $paystack->getAuthorizationUrl()->redirectNow();
        }
        elseif(Session::get('payment_type') == 'seller_payment'){
            $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
            $paystack = new Paystack($seller->paystack_secret_key, $baseUrl);
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round(Session::get('payment_data')['amount'] * 100);
            // $request->key = $seller->paystack_secret_key;
            $request->reference = $paystack->genTranxRef();
            return $paystack->getAuthorizationUrl()->redirectNow();
        }
        elseif(Session::get('payment_type') == 'wallet_payment'){
            $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
            $user = Auth::user();
            $request->email = $user->email;
            $request->amount = round(Session::get('payment_data')['amount'] * 100);
            // $request->key = env('PAYSTACK_SECRET_KEY');
            $request->reference = $paystack->genTranxRef();
            return $paystack->getAuthorizationUrl()->redirectNow();
        }
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        $baseUrl = "https://api.paystack.co";
        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment'){
                $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
                $payment = $paystack->getPaymentData();
                $payment_detalis = json_encode($payment);
                if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('order_id'), $payment_detalis);
                }
                Session::forget('order_id');
                flash(__('Payment cancelled'))->success();
                return redirect()->route('home');
            }
            elseif (Session::get('payment_type') == 'seller_payment') {
                $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
                $paystack = new Paystack($seller->paystack_secret_key, $baseUrl);
                $payment = $paystack->getPaymentData();
                $payment_detalis = json_encode($payment);
                if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                    $commissionController = new CommissionController;
                    return $commissionController->seller_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                Session::forget('payment_data');
                flash(__('Payment cancelled'))->success();
                return redirect()->route('home');
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'), $baseUrl);
                $payment = $paystack->getPaymentData();
                $payment_detalis = json_encode($payment);
                if(!empty($payment['data']) && $payment['data']['status'] == 'success'){
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                Session::forget('payment_data');
                flash(__('Payment cancelled'))->success();
                return redirect()->route('home');
            }
        }
    }
}
