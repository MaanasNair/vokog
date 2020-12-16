@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <div class="panel-control">
            <a href="{{ route('sellers.reject', $seller->id) }}" class="btn btn-default btn-rounded d-innline-block">{{__('Reject')}}</a></li>
            <a href="{{ route('sellers.approve', $seller->id) }}" class="btn btn-primary btn-rounded d-innline-block">{{__('Accept')}}</a>
        </div>
        <h3 class="panel-title">{{__('Seller Verification')}}</h3>
    </div>
    <div class="panel-body">
        <div class="col-md-4">
            <div class="panel-heading">
                <h3 class="text-lg">{{__('User Info')}}</h3>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                <div class="col-sm-9">
                    <p>{{ $seller->user->name }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Email')}}</label>
                <div class="col-sm-9">
                    <p>{{ $seller->user->email }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Address')}}</label>
                <div class="col-sm-9">
                    <p>{{ $seller->user->address }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Phone')}}</label>
                <div class="col-sm-9">
                    <p>{{ $seller->user->phone }}</p>
                </div>
            </div>


            <div class="panel-heading">
                <h3 class="text-lg">{{__('Shop Info')}}</h3>
            </div>

            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Shop Name')}}</label>
                <div class="col-sm-9">
                    <p>{{ $seller->user->shop->name }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Address')}}</label>
                <div class="col-sm-9">
                    <p>{{ $seller->user->shop->address }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel-heading">
                <h3 class="text-lg">{{__('Verification Info')}}</h3>
            </div>
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <tbody>
                    @foreach (json_decode($seller->verification_info) as $key => $info)
                        <tr>
                            <th>{{ $info->label }}</th>
                            @if ($info->type == 'text' || $info->type == 'select' || $info->type == 'radio')
                                <td>{{ $info->value }}</td>
                            @elseif ($info->type == 'multi_select')
                                <td>
                                    {{ implode(json_decode($info->value), ', ') }}
                                </td>
                            @elseif ($info->type == 'file')
                                <td>
                                    <a href="{{ asset($info->value) }}" target="_blank" class="btn-info">{{__('Click here')}}</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                <a href="{{ route('sellers.reject', $seller->id) }}" class="btn btn-default d-innline-block">{{__('Reject')}}</a></li>
                <a href="{{ route('sellers.approve', $seller->id) }}" class="btn btn-primary d-innline-block">{{__('Accept')}}</a>
            </div>
        </div>
    </div>
</div>

@endsection
