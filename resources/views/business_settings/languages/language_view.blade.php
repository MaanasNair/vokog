@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $language->name }}</h3>
            </div>
            <form class="form-horizontal" action="{{ route('languages.key_value_store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $language->id }}">
                <div class="panel-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Key')}}</th>
                                <th>{{__('Value')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach (openJSONFile('en') as $key => $value)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $key }}</td>
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}]" @isset(openJSONFile($language->code)[$key])
                                                value="{{ openJSONFile($language->code)[$key] }}"
                                            @endisset>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer text-right">
    				<button type="submit" class="btn btn-purple">{{ __('Save') }}</button>
    			</div>
            </form>
        </div>
    </div>

@endsection
