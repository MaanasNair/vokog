@extends('layouts.app')

@section('content')

    <div class="panel">
    	<div class="panel-body">
    		<div class="invoice-masthead">
    			<div class="invoice-text">
    				<h3 class="h1 text-thin mar-no text-primary">{{ __('Order Details') }}</h3>
    			</div>
    		</div>
            <div class="row">
                @php
                    $delivery_status = $order->orderDetails->first()->delivery_status;
                    $payment_status = $order->orderDetails->first()->payment_status;
                @endphp
                <div class="col-lg-offset-6 col-lg-3">
                    <label for=update_payment_status"">{{__('Payment Status')}}</label>
                    <select class="form-control demo-select2"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                        <option value="paid" @if ($payment_status == 'paid') selected @endif>{{__('Paid')}}</option>
                        <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{__('Unpaid')}}</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for=update_delivery_status"">{{__('Delivery Status')}}</label>
                    <select class="form-control demo-select2"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                        <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{__('Pending')}}</option>
                        <option value="on_review" @if ($delivery_status == 'on_review') selected @endif>{{__('On review')}}</option>
                        <option value="on_delivery" @if ($delivery_status == 'on_delivery') selected @endif>{{__('On delivery')}}</option>
                        <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{__('Delivered')}}</option>
                    </select>
                </div>
            </div>
            <hr>
    		<div class="invoice-bill row">
    			<div class="col-sm-6 text-xs-center">
    				<address>
        				<strong class="text-main">{{ json_decode($order->shipping_address)->name }}</strong><br>
                         {{ json_decode($order->shipping_address)->email }}<br>
                         {{ json_decode($order->shipping_address)->phone }}<br>
        				 {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->country }}
                    </address>
    			</div>
    			<div class="col-sm-6 text-xs-center">
    				<table class="invoice-details">
    				<tbody>
    				<tr>
    					<td class="text-main text-bold">
    						{{__('Order #')}}
    					</td>
    					<td class="text-right text-info text-bold">
    						{{ $order->code }}
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main text-bold">
    						{{__('Order Status')}}
    					</td>
                        @php
                            $status = $order->orderDetails->first()->delivery_status;
                        @endphp
    					<td class="text-right">
                            @if($status == 'delivered')
                                <span class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                            @else
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                            @endif
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main text-bold">
    						{{__('Order Date')}}
    					</td>
    					<td class="text-right">
    						{{ date('d-m-Y h:i A', $order->date) }} (UTC)
    					</td>
    				</tr>
                    <tr>
    					<td class="text-main text-bold">
    						{{__('Total amount')}}
    					</td>
    					<td class="text-right">
    						{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}
    					</td>
    				</tr>
                    <tr>
    					<td class="text-main text-bold">
    						{{__('Payment method')}}
    					</td>
    					<td class="text-right">
    						{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
    					</td>
    				</tr>
    				</tbody>
    				</table>
    			</div>
    		</div>
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                                <th class="min-col">#</th>
            					<th class="text-uppercase">
            						{{__('Description')}}
            					</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Qty')}}
            					</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Price')}}
            					</th>
            					<th class="min-col text-right text-uppercase">
            						{{__('Total')}}
            					</th>
            				</tr>
        				</thead>
        				<tbody>
                            @foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                					<td>
                						<strong><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->name }}</a></strong>
                						<small>{{ $orderDetail->variation }}</small>
                					</td>
                					<td class="text-center">
                						{{ $orderDetail->quantity }}
                					</td>
                					<td class="text-center">
                						{{ single_price($orderDetail->price/$orderDetail->quantity) }}
                					</td>
                                    <td class="text-center">
                						{{ single_price($orderDetail->price) }}
                					</td>
                				</tr>
                            @endforeach
        				</tbody>
    				</table>
    			</div>
    		</div>
    		<div class="clearfix">
    			<table class="table invoice-total">
    			<tbody>
    			<tr>
    				<td>
    					<strong>{{__('Sub Total')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price')) }}
    				</td>
    			</tr>
    			<tr>
    				<td>
    					<strong>{{__('Tax')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax')) }}
    				</td>
    			</tr>
                <tr>
    				<td>
    					<strong>{{__('Shipping')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('shipping_cost')) }}
    				</td>
    			</tr>
    			<tr>
    				<td>
    					<strong>{{__('TOTAL')}} :</strong>
    				</td>
    				<td class="text-bold h4">
    					{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price') + $order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax') + $order->orderDetails->where('seller_id', Auth::user()->id)->sum('shipping_cost')) }}
    				</td>
    			</tr>
    			</tbody>
    			</table>
    		</div>
    		<div class="text-right no-print">
    			<a href="{{ route('customer.invoice.download', $order->id) }}" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a>
    		</div>
    	</div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                showAlert('success', 'Delivery status has been updated');
            });
        });

        $('#update_payment_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                showAlert('success', 'Payment status has been updated');
            });
        });
    </script>
@endsection
