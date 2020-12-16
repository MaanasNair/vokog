@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">{{__('Google Analytics Setting')}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('google_analytics.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Google Analytics')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="switch">
                                    <input value="1" name="google_analytics" type="checkbox" @if (\App\BusinessSetting::where('type', 'google_analytics')->first()->value == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="TRACKING_ID">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Tracking ID')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="TRACKING_ID" value="{{  env('TRACKING_ID') }}" placeholder="Tracking ID" required>
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
