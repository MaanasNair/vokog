@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('SMTP Settings')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_DRIVER">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL DRIVER')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_DRIVER" value="{{  env('MAIL_DRIVER') }}" placeholder="MAIL DRIVER" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_HOST">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL HOST')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_HOST" value="{{  env('MAIL_HOST') }}" placeholder="MAIL HOST" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_PORT">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL PORT')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_PORT" value="{{  env('MAIL_PORT') }}" placeholder="MAIL PORT" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_USERNAME">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL USERNAME')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_USERNAME" value="{{  env('MAIL_USERNAME') }}" placeholder="MAIL USERNAME" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL PASSWORD')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_PASSWORD" value="{{  env('MAIL_PASSWORD') }}" placeholder="MAIL PASSWORD" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL ENCRYPTION')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_ENCRYPTION" value="{{  env('MAIL_ENCRYPTION') }}" placeholder="MAIL ENCRYPTION" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL FROM ADDRESS')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_FROM_ADDRESS" value="{{  env('MAIL_FROM_ADDRESS') }}" placeholder="MAIL FROM ADDRESS" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="MAIL_FROM_NAME">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('MAIL FROM NAME')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="MAIL_FROM_NAME" value="{{  env('MAIL_FROM_NAME') }}" placeholder="MAIL FROM NAME" required>
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
