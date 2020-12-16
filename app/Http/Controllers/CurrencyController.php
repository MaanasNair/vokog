<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{

    public function changeCurrency(Request $request)
    {
    	$request->session()->put('currency_code', $request->currency_code);
        $currency = Currency::where('code', $request->currency_code)->first();
    	flash(__('Currency changed to ').$currency->name)->success();
    }

    public function currency(Request $request)
    {
        $currencies = Currency::all();
        $active_currencies = Currency::where('status', 1)->get();
        return view('business_settings.currency', compact('currencies', 'active_currencies'));
    }

    public function updateCurrency(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $request->status;
        if($currency->save()){
            flash('Currency updated successfully')->success();
            return '1';
        }
        flash('Something went wrong')->error();
        return '0';
    }

    public function updateYourCurrency(Request $request)
    {
        $currency = Currency::findOrFail($request->id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $request->status;
        if($currency->save()){
            flash('Currency updated successfully')->success();
            return '1';
        }
        flash('Something went wrong')->error();
        return '0';
    }
}
