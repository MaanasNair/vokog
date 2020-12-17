<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use App\Order;
use App\BusinessSetting;
use App\Seller;
use Session;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\WalletController;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment' || Session::get('payment_type') == 'wallet_payment'){
                return view('frontend.payment.stripe');
            }
            elseif (Session::get('payment_type') == 'seller_payment') {
                $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
                return view('stripes.stripe', compact('seller'));
            }
        }
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
     function stripePost(Request $request)
    {
        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail(Session::get('order_id'));

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $payment = json_encode(Stripe\Charge::create ([
                        "amount" => round(convert_to_usd($order->grand_total) * 100),
                        "currency" => "usd",
                        "source" => $request->stripeToken
                ]));

                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done($request->session()->get('order_id'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'seller_payment') {
                $seller = Seller::findOrFail($request->session()->get('payment_data')['seller_id']);

                Stripe\Stripe::setApiKey($seller->stripe_secret);

                $payment = json_encode(Stripe\Charge::create ([
                        "amount" => round(convert_to_usd($request->session()->get('payment_data')['amount']) * 100),
                        "currency" => "usd",
                        "source" => $request->stripeToken
                ]));

                $commissionController = new CommissionController;
                return $commissionController->seller_payment_done($request->session()->get('payment_data'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $payment = json_encode(Stripe\Charge::create ([
                        "amount" => round(convert_to_usd($request->session()->get('payment_data')['amount']) * 100),
                        "currency" => "usd",
                        "source" => $request->stripeToken
                ]));

                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), $payment);
            }
        }
    }
}
