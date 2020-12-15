@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="mb-0 h6">{{translate('Seller Payments')}}</h3>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Date')}}</th>
                    <th>{{translate('Seller')}}</th>
                    <th>{{translate('Amount')}}</th>
                    <th>{{ translate('Payment Method') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $key => $payment)
                    @if (\App\Seller::find($payment->seller_id) != null && \App\Seller::find($payment->seller_id)->user != null)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $payment->created_at }}</td>
                            <td>
                                @if (\App\Seller::find($payment->seller_id) != null)
                                    {{ \App\Seller::find($payment->seller_id)->user->name }} ({{ \App\Seller::find($payment->seller_id)->user->shop->name }})
                                @endif
                            </td>
                            <td>
                                {{ single_price($payment->amount) }}
                            </td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} @if ($payment->txn_code != null) (TRX ID : {{ $payment->txn_code }}) @endif</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
              {{ $payments->links() }}
        </div>
    </div>
</div>

@endsection
