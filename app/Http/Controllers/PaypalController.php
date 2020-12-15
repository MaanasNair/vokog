<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Paypal;
use Redirect;
use App\Order;
use App\BusinessSetting;
use App\Seller;
use Session;
use App\CustomerPackage;
use App\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CheckoutController;
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
            elseif (Session::get('payment_type') == 'wallet_payment') {
                $amount->setTotal(convert_to_usd(Session::get('payment_data')['amount']));
                $description = 'Wallet Payment';
            }
            elseif (Session::get('payment_type') == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);
                $amount->setTotal(convert_to_usd($customer_package->amount));
                $description = 'Customer Package Payment';
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
                $amount->setTotal(convert_to_usd($seller_package->amount));
                $description = 'Seller Package Payment';
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


    public function getCancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('order_id');
        $request->session()->forget('payment_data');
        flash(translate('Payment cancelled'))->success();
    	return redirect()->route('home');
    }

    public function getDone(Request $request)
    {
    	$payment_id = $request->get('paymentId');
    	$token = $request->get('token');
    	$payer_id = $request->get('PayerID');

        if(BusinessSetting::where('type', 'paypal_sandbox')->first()->value == 1){
            $mode = 'sandbox';
            $endPoint = 'https://api.sandbox.paypal.com';
        }
        else{
            $mode = 'live';
            $endPoint = 'https://api.paypal.com';
        }
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

        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $payment = PayPal::getById($payment_id, $this->_apiContext);
                $paymentExecution = PayPal::PaymentExecution();
            	$paymentExecution->setPayerId($payer_id);
            	$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

                $payment = json_encode($executePayment);

                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done($request->session()->get('order_id'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $payment = PayPal::getById($payment_id, $this->_apiContext);
                $paymentExecution = PayPal::PaymentExecution();
            	$paymentExecution->setPayerId($payer_id);
            	$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

                $payment = json_encode($executePayment);

                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'customer_package_payment') {
                $payment = PayPal::getById($payment_id, $this->_apiContext);
                $paymentExecution = PayPal::PaymentExecution();
            	$paymentExecution->setPayerId($payer_id);
            	$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

                $payment = json_encode($executePayment);

                $customer_package_controller = new CustomerPackageController;
                return $customer_package_controller->purchase_payment_done($request->session()->get('payment_data'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'seller_package_payment') {
                $payment = PayPal::getById($payment_id, $this->_apiContext);
                $paymentExecution = PayPal::PaymentExecution();
            	$paymentExecution->setPayerId($payer_id);
            	$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

                $payment = json_encode($executePayment);

                $seller_package_controller = new SellerPackageController;
                return $seller_package_controller->purchase_payment_done($request->session()->get('payment_data'), $payment);
            }
        }
    }
}
