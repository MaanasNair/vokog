@extends('backend.layouts.app')

@section('content')

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Subcategory Information')}}</h5>
        </div>
        <form class="form-horizontal" action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">{{translate('Name')}}</label>
                    <div class="col-md-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">{{translate('Category')}}</label>
                    <div class="col-md-9">
                        <select name="category_id" required class="form-control aiz-selectpicker mb-2 mb-md-0">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{ $category->getTranslation('name')}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Meta Title')}}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="meta_title" placeholder="{{translate('Meta Title')}}">
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-md-3 col-form-label">{{translate('Meta Description')}}</label>
                    <div class="col-md-9">
                        <textarea name="meta_description" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
            </div>
        </form>
    </div>
</div>

@endsection
