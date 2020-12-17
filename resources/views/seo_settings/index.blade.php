@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('SEO Settings')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('seosetting.update',$seosetting->id ) }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tag">{{__('Keyword')}}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tags[]" value="{{ $seosetting->keyword }}" placeholder="{{__('Type and Hit Enter')}}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="address">{{__('Author')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="author" name="author" value="{{ $seosetting->author }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="revisit">{{__('Revisit After')}}</label>
                        <div class="col-sm-8">
                            <input type="number" min="0" step="1" value="{{ $seosetting->revisit }}" placeholder="{{__('Revisit After')}}" name="revisit" class="form-control" required>
                        </div>
                        <label class="col-sm-1 control-label" for="days">{{__('Days')}}</label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sitemap">{{__('Sitemap Link')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="sitemap" name="sitemap" value="{{ $seosetting->sitemap_link }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="description">{{__('Description')}}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="5" name="description">{{ $seosetting->description }}</textarea>
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
