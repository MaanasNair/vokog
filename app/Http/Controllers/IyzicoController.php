<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\BusinessSetting;
use App\Seller;
use App\CustomerPackage;
use App\SellerPackage;
use Session;
use Redirect;

class IyzicoController extends Controller
{
    public function index(Request $request){

    }

    public function pay(){
        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZICO_API_KEY'));
        $options->setSecretKey(env('IYZICO_SECRET_KEY'));

        if(BusinessSetting::where('type', 'iyzico_sandbox')->first()->value == 1) {
            $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        } else {
            $options->setBaseUrl("https://api.iyzipay.com");
        }

        if(Session::has('payment_type')){
            $request = new \Iyzipay\Request\CreatePayWithIyzicoInitializeRequest();
            $request->setLocale(\Iyzipay\Model\Locale::TR);
            $request->setConversationId('123456789');

            $buyer = new \Iyzipay\Model\Buyer();
            $buyer->setId("BY789");
            $buyer->setName("John");
            $buyer->setSurname("Doe");
            $buyer->setEmail("email@email.com");
            $buyer->setIdentityNumber("74300864791");
            $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $buyer->setCity("Istanbul");
            $buyer->setCountry("Turkey");
            $request->setBuyer($buyer);

            $shippingAddress = new \Iyzipay\Model\Address();
            $shippingAddress->setContactName("Jane Doe");
            $shippingAddress->setCity("Istanbul");
            $shippingAddress->setCountry("Turkey");
            $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $request->setShippingAddress($shippingAddress);

            $billingAddress = new \Iyzipay\Model\Address();
            $billingAddress->setContactName("Jane Doe");
            $billingAddress->setCity("Istanbul");
            $billingAddress->setCountry("Turkey");
            $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $request->setBillingAddress($billingAddress);

            if(Session::get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail(Session::get('order_id'));

                $request->setPrice(round($order->grand_total));
                $request->setPaidPrice(round($order->grand_total));
                $request->setCurrency(\Iyzipay\Model\Currency::TL);
                $request->setBasketId(rand(000000,999999));
                $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
                $request->setCallbackUrl(route('iyzico.callback'));

                $basketItems = array();
                $firstBasketItem = new \Iyzipay\Model\BasketItem();
                $firstBasketItem->setId(rand(1000,9999));
                $firstBasketItem->setName("Cart Payment");
                $firstBasketItem->setCategory1("Accessories");
                $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $firstBasketItem->setPrice(round($order->grand_total));
                $basketItems[0] = $firstBasketItem;

                $request->setBasketItems($basketItems);
            }

            if(Session::get('payment_type') == 'wallet_payment'){
                $request->setPrice(round(Session::get('payment_data')['amount']));
                $request->setPaidPrice(round(Session::get('payment_data')['amount']));
                $request->setCurrency(\Iyzipay\Model\Currency::TL);
                $request->setBasketId(rand(000000,999999));
                $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
                $request->setCallbackUrl(route('iyzico.callback'));

                $basketItems = array();
                $firstBasketItem = new \Iyzipay\Model\BasketItem();
                $firstBasketItem->setId(rand(1000,9999));
                $firstBasketItem->setName("Wallet Payment");
                $firstBasketItem->setCategory1("Wallet");
                $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $firstBasketItem->setPrice(round(Session::get('payment_data')['amount']));
                $basketItems[0] = $firstBasketItem;

                $request->setBasketItems($basketItems);
            }

            if(Session::get('payment_type') == 'customer_package_payment'){
                $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);

                $request->setPrice(round($customer_package->amount));
                $request->setPaidPrice(round($customer_package->amount));
                $request->setCurrency(\Iyzipay\Model\Currency::TL);
                $request->setBasketId(rand(000000,999999));
                $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
                $request->setCallbackUrl(route('iyzico.callback'));

                $basketItems = array();
                $firstBasketItem = new \Iyzipay\Model\BasketItem();
                $firstBasketItem->setId(rand(1000,9999));
                $firstBasketItem->setName("Package Payment");
                $firstBasketItem->setCategory1("Package");
                $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $firstBasketItem->setPrice(round($customer_package->amount));
                $basketItems[0] = $firstBasketItem;

                $request->setBasketItems($basketItems);
            }

            if(Session::get('payment_type') == 'seller_package_payment'){
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);

                $request->setPrice(round($seller_package->amount));
                $request->setPaidPrice(round($seller_package->amount));
                $request->setCurrency(\Iyzipay\Model\Currency::TL);
                $request->setBasketId(rand(000000,999999));
                $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
                $request->setCallbackUrl(route('iyzico.callback'));

                $basketItems = array();
                $firstBasketItem = new \Iyzipay\Model\BasketItem();
                $firstBasketItem->setId(rand(1000,9999));
                $firstBasketItem->setName("Package Payment");
                $firstBasketItem->setCategory1("Package");
                $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $firstBasketItem->setPrice(round($seller_package->amount));
                $basketItems[0] = $firstBasketItem;

                $request->setBasketItems($basketItems);
            }


            # make request
            $payWithIyzicoInitialize = \Iyzipay\Model\PayWithIyzicoInitialize::create($request, $options);

            # print result
            return Redirect::to($payWithIyzicoInitialize->getPayWithIyzicoPageUrl());
        }
        else {
            flash(translate('Opps! Something went wrong.'))->warning();
            return redirect()->route('cart');
        }
    }

    public function callback(Request $req){
        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZICO_API_KEY'));
        $options->setSecretKey(env('IYZICO_SECRET_KEY'));

        if(BusinessSetting::where('type', 'iyzico_sandbox')->first()->value == 1) {
            $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        } else {
            $options->setBaseUrl("https://api.iyzipay.com");
        }

        $request = new \Iyzipay\Request\RetrievePayWithIyzicoRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId('123456789');
        $request->setToken($req->token);
        # make request
        $payWithIyzico = \Iyzipay\Model\PayWithIyzico::retrieve($request, $options);

        if ($payWithIyzico->getStatus() == 'success') {
            if(Session::get('payment_type') == 'cart_payment'){
                $payment = $payWithIyzico->getRawResult();

                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done(Session::get('order_id'), $payment);
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                $payment = $payWithIyzico->getRawResult();

                $walletController = new WalletController;
                return $walletController->wallet_payment_done(Session::get('payment_data'), $payment);
            }
            elseif (Session::get('payment_type') == 'customer_package_payment') {
                $payment = $payWithIyzico->getRawResult();

                $customer_package_controller = new CustomerPackageController;
                return $customer_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                $payment = $payWithIyzico->getRawResult();

                $seller_package_controller = new SellerPackageController;
                return $seller_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
            }
        }
    }
}
