<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypal;
use Redirect;
use App\Order;
use App\BusinessSetting;
use App\Seller;
use Session;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\WalletController;

class PaypalController extends Controller
{
    private $_apiContext;

    public function __construct()
    {
        if(Session::has('payment_type')){

            if(BusinessSetting::where('type', 'paypal_sandbox')->first()->value == 1){
                $mode = 'sandbox';
                $endPoint = 'https://api.sandbox.paypal.com';
            }
            else{
                $mode = 'live';
                $endPoint = 'https://api.paypal.com';
            }

            if(Session::get('payment_type') == 'cart_payment' || Session::get('payment_type') == 'wallet_payment'){
                $this->_apiContext = PayPal::ApiContext(
                    env('PAYPAL_CLIENT_ID'),
                    env('PAYPAL_CLIENT_SECRET'));

        		$this->_apiContext->setConfig(array(
        			'mode' => $mode,
        			'service.EndPoint' => $endPoint,
        			'http.ConnectionTimeOut' => 30,
        			'log.LogEnabled' => true,
        			'log.FileName' => public_path('logs/paypal.log'),
        			'log.LogLevel' => 'FINE'
        		));
            }
            elseif (Session::get('payment_type') == 'seller_payment') {
                $seller = Seller::findOrFail(Session::get('payment_details')['seller_id']);
                $this->_apiContext = PayPal::ApiContext(
                    $seller->paypal_client_id,
                    $seller->paypal_client_secret);

        		$this->_apiContext->setConfig(array(
        			'mode' => $mode,
        			'service.EndPoint' => 'https://api.paypal.com',
        			'http.ConnectionTimeOut' => 30,
        			'log.LogEnabled' => true,
        			'log.FileName' => public_path('logs/paypal.log'),
        			'log.LogLevel' => 'FINE'
        		));
            }
        }
    }

    public function getCheckout()
    {
    	$payer = PayPal::Payer();
    	$payer->setPaymentMethod('paypal');
    	$amount = PayPal::Amount();
    	$amount->setCurrency('USD');

        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail(Session::get('order_id'));
                $amount->setTotal(convert_to_usd($order->grand_total));
                $description = 'Payment for order completion';
            }
            elseif (Session::get('payment_type') == 'seller_payment' || Session::get('payment_type') == 'wallet_payment') {
                $amount->setTotal(convert_to_usd(Session::get('payment_data')['amount']));
                $description = 'Payment to seller';
            }
        }
    	// This is the simple way,
    	// you can alternatively describe everything in the order separately;
    	// Reference the PayPal PHP REST SDK for details.
    	$transaction = PayPal::Transaction();
    	$transaction->setAmount($amount);
    	$transaction->setDescription($description);
    	$redirectUrls = PayPal:: RedirectUrls();
    	$redirectUrls->setReturnUrl(url('paypal/payment/done'));
    	$redirectUrls->setCancelUrl(url('paypal/payment/cancel'));
    	$payment = PayPal::Payment();
    	$payment->setIntent('sale');
    	$payment->setPayer($payer);
    	$payment->setRedirectUrls($redirectUrls);
    	$payment->setTransactions(array($transaction));
    	$response = $payment->create($this->_apiContext);
    	$redirectUrl = $response->links[1]->href;

    	return Redirect::to( $redirectUrl );
    }


    public function getCancel()
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('order_id');
        $request->session()->forget('payment_data');
        flash(__('Payment cancelled'))->success();
    	return redirect()->url()->previous();
    }

    public function getDone(Request $request)
    {
    	$payment_id = $request->get('paymentId');
    	$token = $request->get('token');
    	$payer_id = $request->get('PayerID');

        $payment = '';
    	// $payment = PayPal::getById($payment_id, $this->_apiContext);
    	// $paymentExecution = PayPal::PaymentExecution();
    	// $paymentExecution->setPayerId($payer_id);
    	// $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done($request->session()->get('order_id'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'seller_payment') {
                $commissionController = new CommissionController;
                return $commissionController->seller_payment_done($request->session()->get('payment_data'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), $payment);
            }
        }
    }
}
