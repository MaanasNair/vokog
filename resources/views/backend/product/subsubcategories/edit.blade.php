@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Sub SubCategory Information')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-fill border-light">
      				@foreach (\App\Language::all() as $key => $language)
      					<li class="nav-item">
      						<a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('subsubcategories.edit', ['id'=>$subsubcategory->id, 'lang'=> $language->code] ) }}">
      							<img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
      							<span>{{$language->name}}</span>
      						</a>
      					</li>
      		        @endforeach
      			</ul>
            <form class="p-4" action="{{ route('subsubcategories.update', $subsubcategory->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                <input type="hidden" name="lang" value="{{ $lang }}">
                @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" value="{{ $subsubcategory->getTranslation('name', $lang) }}" class="form-control" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Category')}}</label>
                        <div class="col-sm-9">
                            <select name="category_id" id="category_id" class="form-control aiz-selectpicker" required>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{ $category->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Subcategory')}}</label>
                        <div class="col-sm-9">
                            <select name="sub_category_id" id="sub_category_id" class="form-control aiz-selectpicker" required>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{translate('Meta Title')}}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="meta_title" value="{{ $subsubcategory->meta_title }}" placeholder="{{translate('Meta Title')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{translate('Meta Description')}}</label>
                        <div class="col-sm-9">
                            <textarea name="meta_description" rows="8" class="form-control">{{ $subsubcategory->meta_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Slug')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug" value="{{ $subsubcategory->slug }}" class="form-control">
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


@section('script')

<script type="text/javascript">


    function get_subcategories_by_category(){
		var category_id = $('#category_id').val();
		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
  		    $('#sub_category_id').html(null);
              var extra = "";
  		    for (var i = 0; i < data.length; i++) {
                  data[i].id == '{{ $subsubcategory->sub_category_id }}' ? extra = "selected " : extra = "";

                  $('#sub_category_id').append($(`<option value="${data[i].id}" ${extra}>${data[i].name}</option>`));
  		    }
  		    $(".aiz-selectpicker").selectpicker();
  		});
  	}


    $(document).ready(function(){
        $("#category_id > option").each(function() {
            if(this.value == '{{$subsubcategory->subcategory->category_id}}'){
                $("#category_id").val(this.value).change();
            }
        });
        get_subcategories_by_category();
    });

    $('#category_id').on('change', function() {
        get_subcategories_by_category();
    });

</script>

@endsection
