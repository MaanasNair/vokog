@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Paypal Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    <input type="hidden" name="payment_method" value="paypal">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Paypal Client Id')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="PAYPAL_CLIENT_ID" value="{{  env('PAYPAL_CLIENT_ID') }}" placeholder="Paypal Client ID" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Paypal Client Secret')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET" value="{{  env('PAYPAL_CLIENT_SECRET') }}" placeholder="Paypal Client Secret" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Paypal Sandbox Mode')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <label class="switch">
                                <input value="1" name="paypal_sandbox" type="checkbox" @if (\App\BusinessSetting::where('type', 'paypal_sandbox')->first()->value == 1)
                                    checked
                                @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Sslcommerz Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="sslcommerz">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="SSLCZ_STORE_ID">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Sslcz Store Id')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="SSLCZ_STORE_ID" value="{{  env('SSLCZ_STORE_ID') }}" placeholder="{{__('Sslcz Store Id')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="SSLCZ_STORE_PASSWD">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Sslcz store password')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="SSLCZ_STORE_PASSWD" value="{{  env('SSLCZ_STORE_PASSWD') }}" placeholder="{{__('Sslcz store password')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Sslcommerz Sandbox Mode')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <label class="switch">
                                <input value="1" name="sslcommerz_sandbox" type="checkbox" @if (\App\BusinessSetting::where('type', 'sslcommerz_sandbox')->first()->value == 1)
                                    checked
                                @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Stripe Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="stripe">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="STRIPE_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Stripe Key')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="STRIPE_KEY" value="{{  env('STRIPE_KEY') }}" placeholder="STRIPE KEY" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="STRIPE_SECRET">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Stripe Secret')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="STRIPE_SECRET" value="{{  env('STRIPE_SECRET') }}" placeholder="STRIPE SECRET" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('RazorPay Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="razorpay">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="RAZOR_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('RAZOR KEY')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="RAZOR_KEY" value="{{  env('RAZOR_KEY') }}" placeholder="RAZOR KEY" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="RAZOR_SECRET">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('RAZOR SECRET')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="RAZOR_SECRET" value="{{  env('RAZOR_SECRET') }}" placeholder="RAZOR SECRET" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Instamojo Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="instamojo">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="IM_API_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('API KEY')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="IM_API_KEY" value="{{  env('IM_API_KEY') }}" placeholder="IM API KEY" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="IM_AUTH_TOKEN">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('AUTH TOKEN')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="IM_AUTH_TOKEN" value="{{  env('IM_AUTH_TOKEN') }}" placeholder="IM AUTH TOKEN" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Instamojo Sandbox Mode')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <label class="switch">
                                <input value="1" name="instamojo_sandbox" type="checkbox" @if (\App\BusinessSetting::where('type', 'instamojo_sandbox')->first()->value == 1)
                                    checked
                                @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('PayStack Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="paystack">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYSTACK_PUBLIC_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('PUBLIC KEY')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="PAYSTACK_PUBLIC_KEY" value="{{  env('PAYSTACK_PUBLIC_KEY') }}" placeholder="PUBLIC KEY" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="PAYSTACK_SECRET_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('SECRET KEY')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="PAYSTACK_SECRET_KEY" value="{{  env('PAYSTACK_SECRET_KEY') }}" placeholder="SECRET KEY" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MERCHANT_EMAIL">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MERCHANT EMAIL')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MERCHANT_EMAIL" value="{{  env('MERCHANT_EMAIL') }}" placeholder="MERCHANT EMAIL" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
