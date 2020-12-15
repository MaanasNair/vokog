@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Sub Category Information')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-fill border-light">
				@foreach (\App\Language::all() as $key => $language)
					<li class="nav-item">
						<a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('subcategories.edit', ['id'=>$subcategory->id, 'lang'=> $language->code] ) }}">
							<img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
							<span>{{$language->name}}</span>
						</a>
					</li>
		        @endforeach
			</ul>
            <form class="p-4" action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                <input type="hidden" name="lang" value="{{ $lang }}">
            	@csrf
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="name">{{translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                    <div class="col-md-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{$subcategory->getTranslation('name',$lang)}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-Label" for="name">{{translate('Category')}}</label>
                    <div class="col-md-9">
                        <select name="category_id" required class="form-control aiz-selectpicker mb-2 mb-md-0">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" <?php if($subcategory->category_id == $category->id) echo "selected";?> >{{ $category->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Meta Title')}}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="meta_title" value="{{ $subcategory->meta_title }}" placeholder="{{translate('Meta Title')}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Meta Description')}}</label>
                    <div class="col-md-9">
                        <textarea name="meta_description" rows="5" class="form-control">{{ $subcategory->meta_description }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-md-3 col-form-label" for="name">{{translate('Slug')}}</label>
                <div class="col-md-9">
                    <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug" value="{{ $subcategory->slug }}" class="form-control">
                </div>
            </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
