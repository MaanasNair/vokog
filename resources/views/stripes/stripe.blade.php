@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Stripe Payment')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal require-validation" role="form" action="{{ route('stripe.post') }}" method="post"
                data-cc-on-file="false"
                data-stripe-publishable-key="{{ $seller->stripe_key }}"
                id="payment-form">
            	@csrf
                <div class="panel-body">

                    <div class="text-center" >
                        <h3>{{__('Payment Details')}}</h3>
                        <img class="img-fluid" src="http://i76.imgup.net/accepted_c22e0.png" height="30" style="margin-bottom:10px;">
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name">{{__('Name on Card')}}</label>
                        <div class="col-sm-10 required">
                            <input type="text" autocomplete='off' placeholder="{{__('Name on Card')}}" size='20' id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="card_number">{{__('Card Number')}}</label>
                        <div class="col-sm-10 required">
                            <input type="text" autocomplete='off' placeholder="{{__('Card Number')}}" id="card_number" name="card_number" class="form-control card-number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="cvc">{{__('CVC')}}</label>
                        <div class="col-sm-10 cvc required">
                            <input type="text" placeholder="{{__('ex. 321')}}" size='4' id="cvc" name="cvc" class="form-control card-cvc" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="exp_month">{{__('Expiration Month')}}</label>
                        <div class="col-sm-10 expiration required">
                            <input type="text" placeholder="{{__('MM')}}" size='2' id="exp_month" name="exp_month" class="form-control card-expiry-month" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="exp_year">{{__('Expiration Year')}}</label>
                        <div class="col-sm-10 expiration required">
                            <input type="text" placeholder="{{__('YYYY')}}" size='4' id="exp_year" name="exp_year" class="form-control card-expiry-year" required>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 error form-group hide'>
                            <div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Pay Now')}} (${{ number_format(convert_to_usd(Session::get('payment_data')['amount']), 2) }})</button>
                </div>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {
            var $form         = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                var $form         = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                                 'input[type=text]', 'input[type=file]',
                                 'textarea'].join(', '),
                $inputs       = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid         = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                  var $input = $(el);
                  if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                  }
                });

                if (!$form.data('cc-on-file')) {
                  e.preventDefault();
                  Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                  Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                  }, stripeResponseHandler);
                }

            });

          function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>
@endsection
