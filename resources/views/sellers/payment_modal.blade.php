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
                    {{-- <tr>
                        <td>Total Sold</td>
                        <td>$177.9</td>
                    </tr>
                    <tr>
                        <td>Total Commission</td>
                        <td>$53.37</td>
                    </tr>
                    <tr>
                        <td>Paid By Customer</td>
                        <td>$177.9</td>
                    </tr>
                    <tr>
                        <td>Commission On Paid</td>
                        <td>$53.37</td>
                    </tr>
                    <tr>
                        <td>Paid To Vendor (By Admin)</td>
                        <td>$0</td>
                    </tr> --}}

                    <tr>
                        <td>{{ __('Due to seller') }}</td>
                        <td>{{ single_price($seller->admin_to_pay) }}</td>
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
