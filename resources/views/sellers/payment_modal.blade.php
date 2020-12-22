<form class="form-horizontal" action="{{ route('commissions.pay_to_seller') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">{{__('Pay to seller')}}</h4>
    </div>

    <div class="modal-body">
        <div>
            <table class="table table-responsive">
                <tbody>
                    <tr>
                        @if($seller->admin_to_pay >= 0)
                            <td>{{ __('Due to seller') }}</td>
                            <td>{{ single_price($seller->admin_to_pay) }}</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($seller->admin_to_pay > 0)
            <input type="hidden" name="seller_id" value="{{ $seller->id }}">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="amount">{{__('Amount')}}</label>
                <div class="col-sm-9">
                    <input type="number" min="0" step="0.01" name="amount" id="amount" value="{{ $seller->admin_to_pay }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="payment_option">{{__('Payment Method')}}</label>
                <div class="col-sm-9">
                    <select name="payment_option" id="payment_option" class="form-control demo-select2-placeholder" required>
                        <option value="">{{__('Select Payment Method')}}</option>
                        @if($seller->cash_on_delivery_status == 1)
                            <option value="cash">{{__('Cash')}}</option>
                        @endif
                        @if($seller->paypal_status == 1)
                            <option value="paypal">{{__('Paypal')}}</option>
                        @endif
                        @if($seller->stripe_status == 1)
                            <option value="stripe">{{__('Stripe')}}</option>
                        @endif
                        @if($seller->instamojo_status == 1)
                            <option value="instamojo">{{__('Instamojo')}}</option>
                        @endif
                        @if($seller->razorpay_status == 1)
                            <option value="razorpay">{{__('RazorPay')}}</option>
                        @endif
                        @if($seller->paystack_status == 1)
                            <option value="paystack">{{__('PayStack')}}</option>
                        @endif
                        @if($seller->sslcommerz_status == 1)
                            <option value="sslcommerz">{{__('SSLCommerz')}}</option>
                        @endif
                    </select>
                </div>
            </div>
        @endif

    </div>
    <div class="modal-footer">
        <div class="panel-footer text-right">
            @if ($seller->admin_to_pay > 0)
                <button class="btn btn-purple" type="submit">{{__('Pay')}}</button>
            @endif
            <button class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
        </div>
    </div>
</form>
