@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Home Default Currency')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Home Default Currency')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control demo-select2-placeholder" name="home_default_currency">
                                @foreach ($active_currencies as $key => $currency)
                                    <option value="{{ $currency->id }}" <?php if(\App\BusinessSetting::where('type', 'home_default_currency')->first()->value == $currency->id) echo 'selected'?> >{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="types[]" value="home_default_currency">
                        <div class="col-lg-3">
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
                <h3 class="panel-title text-center">{{__('System Default Currency')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('System Default Currency')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control demo-select2-placeholder" name="system_default_currency">
                                @foreach ($active_currencies as $key => $currency)
                                    <option value="{{ $currency->id }}" <?php if(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value == $currency->id) echo 'selected'?> >{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="types[]" value="system_default_currency">
                        <div class="col-lg-3">
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
                <h3 class="panel-title text-center">{{__('Set Currency Formats')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    {{-- <div class="form-group">
                        <input type="hidden" name="types[]" value="currency_format">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('currency_format')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control demo-select2-placeholder" name="currency_format">
                                <option value="1">US Format - 1,234,567.89</option>
                                <option value="2">German Format - 1.234.567,89</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="symbol_format">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Symbol Format')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control demo-select2-placeholder" name="symbol_format">
                                <option value="1">[Symbol] [Amount]</option>
                                <option value="2">[Amount] [Symbol]</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="no_of_decimals">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('No of decimals')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-control demo-select2-placeholder" name="no_of_decimals">
                                <option value="0">12345</option>
                                <option value="1">1234.5</option>
                                <option value="2">123.45</option>
                                <option value="3">12.345</option>
                            </select>
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

<div class="row">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('All Currency')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Currency name')}}</th>
                        <th>{{__('Currency symbol')}}</th>
                        <th>{{__('Currency code')}}</th>
                        <th>{{__('Exchange rate')}}(1 USD = ?)</th>
                        <th>{{__('Status')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($currencies)-1; $i++)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$currencies[$i]->name}}</td>
                            <td>{{$currencies[$i]->symbol}}</td>
                            <td>{{$currencies[$i]->code}}</td>
                            <td><input id="exchange_rate_{{ $currencies[$i]->id }}" class="form-control" type="number" min="0" step="0.01" value="{{$currencies[$i]->exchange_rate}}"></td>
                            <td><label class="switch"><input id="status_{{ $currencies[$i]->id }}" type="checkbox" <?php if($currencies[$i]->status == 1) echo "checked";?> ><span class="slider round"></span></label></td>
                            <td><button class="btn btn-purple" type="submit" onclick="updateCurrency({{ $currencies[$i]->id }})">{{__('Save')}}</button></td>
                        </tr>
                    @endfor
                    <tr>
                        <td>{{count($currencies)}}</td>
                        <td><input id="name_{{ $currencies[count($currencies)-1]->id }}" class="form-control" type="text" value="{{$currencies[count($currencies)-1]->name}}"></td>
                        <td><input id="symbol_{{ $currencies[count($currencies)-1]->id }}" class="form-control" type="text" value="{{$currencies[count($currencies)-1]->symbol}}"></td>
                        <td><input id="code_{{ $currencies[count($currencies)-1]->id }}" class="form-control" type="text" value="{{$currencies[count($currencies)-1]->code}}"></td>
                        <td><input id="exchange_rate_{{ $currencies[count($currencies)-1]->id }}" class="form-control" type="number" min="0" step="0.01" value="{{$currencies[count($currencies)-1]->exchange_rate}}"></td>
                        <td><label class="switch"><input id="status_{{ $currencies[count($currencies)-1]->id }}" class="demo-sw" type="checkbox" <?php if($currencies[count($currencies)-1]->status == 1) echo "checked";?> ><span class="slider round"></span></label></td>
                        <td><button class="btn btn-purple" type="submit" onclick="updateYourCurrency({{ $currencies[count($currencies)-1]->id }})" >{{__('Save')}}</button></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">

        //Updates default currencies
        function updateCurrency(i){
            var exchange_rate = $('#exchange_rate_'+i).val();
            if($('#status_'+i).is(':checked')){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('currency.update') }}', {_token:'{{ csrf_token() }}', id:i, exchange_rate:exchange_rate, status:status}, function(data){
                location.reload();
            });
        }

        //Updates your currency
        function updateYourCurrency(i){
            var name = $('#name_'+i).val();
            var symbol = $('#symbol_'+i).val();
            var code = $('#code_'+i).val();
            var exchange_rate = $('#exchange_rate_'+i).val();
            if($('#status_'+i).is(':checked')){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('your_currency.update') }}', {_token:'{{ csrf_token() }}', id:i, name:name, symbol:symbol, code:code, exchange_rate:exchange_rate, status:status}, function(data){
                location.reload();
            });
        }
    </script>
@endsection
