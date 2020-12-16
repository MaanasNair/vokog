@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('stocks.create')}}" class="btn btn-danger pull-right">{{__('Destroy')}}</a>
        <a href="{{ route('stocks.create')}}" class="btn btn-info pull-right" style="margin-right: 10px;">{{__('Create Stock')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Product Stocks')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Product Name')}}</th>
                    <th>{{__('Entry Type')}}</th>
                    <th>{{__('Quantity')}}</th>
                    <th>{{__('Note')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($subcategories as $key => $subcategory)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{__($subcategory->name)}}</td>
                        <td>{{$subcategory->category->name}}</td>
                        <td><img class="img-md" src="{{ asset($subcategory->banner) }}" alt="Banner"></td>
                        <td>
                            <a href="{{route('subcategories.edit', $subcategory->id)}}" class="btn btn-mint btn-icon"><i class="demo-psi-pen-5 icon-lg"></i></a>
                            <a onclick="confirm_modal('{{route('subcategories.destroy', $subcategory->id)}}');" class="btn btn-danger btn-icon"><i class="demo-psi-recycling icon-lg"></i></a>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>

    </div>
</div>

@endsection
