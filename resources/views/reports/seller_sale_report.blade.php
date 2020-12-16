@extends('layouts.app')

@section('content')

    <div class="pad-all text-center">
        <form class="" action="{{ route('seller_sale_report.index') }}" method="GET">
            <div class="box-inline mar-btm pad-rgt">
                 Sort by verificarion status:
                 <div class="select">
                     <select class="demo-select2" name="verification_status" required>
                        <option value="1">Approved</option>
                        <option value="0">Non Approved</option>
                     </select>
                 </div>
            </div>
            <button class="btn btn-default" type="submit">Filter</button>
        </form>
    </div>


    <div class="col-md-offset-2 col-md-8">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Seller Based Selling Report') }}</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>Seller Name</th>
                                <th>Shop Name</th>
                                <th>Number of Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellers as $key => $seller)
                                @if($seller->user != null)
                                    <tr>
                                        <td>{{ $seller->user->name }}</td>
                                        <td>{{ $seller->user->shop->name }}</td>
                                        <td>
                                            @php
                                                $num_of_sale = 0;
                                                foreach ($seller->user->products as $key => $product) {
                                                    $num_of_sale += $product->num_of_sale;
                                                }
                                            @endphp
                                            {{ $num_of_sale }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
