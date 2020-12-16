@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <!--Horizontal Form-->

            <form class="form-horizontal" action="{{ route('business_settings.vendor_commission.update') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="panel-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="{{ $business_settings->type }}">
                        <label class="col-lg-3 control-label">{{__('Seller Commission')}}</label>
                        <div class="col-lg-7">
                            <input type="number" min="0" step="0.01" value="{{ $business_settings->value }}" placeholder="{{__('Seller Commission')}}" name="value" class="form-control">
                        </div>
                        <div class="col-lg-1">
                            <option class="form-control">%</option>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                </div>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

        </div>
    </div>


@endsection
