@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                      <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{ translate('Add Your Product') }}</h1>
                        </div>
                      </div>
                    </div>
                    <form class="" action="{{route('customer_products.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
                        @csrf
                        <input type="hidden" name="added_by" value="{{ Auth::user()->user_type }}">
                        <input type="hidden" name="status" value="available">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('General')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Product Name')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="name" placeholder="{{ translate('Product Name')}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Product Category')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Select a Category')}}" id="categories" name="category_id" data-live-search="true" required>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Product SubCategory')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Select a SubCategory')}}" id="subcategories" name="subcategory_id" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Product SubSubCategory')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Select a SubSubCategory')}}" id="subsubcategories" name="subsubcategory_id">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Product Brand')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control selectpicker" data-placeholder="{{ translate('Select a brand')}}" data-live-search="true"  id="brands" name="brand_id">
                                            <option value=""></option>
                                            @foreach (\App\Brand::all() as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Product Unit')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="unit" placeholder="{{ translate('Product unit')}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Condition')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control selectpicker" data-placeholder="{{ translate('Select a condition')}}" id="conditon" name="conditon" required>
                                            <option value="new">{{ translate('New')}}</option>
                                            <option value="used">{{ translate('Used')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Location')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="location" placeholder="{{ translate('Location')}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{ translate('Product Tag')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control aiz-tag-input" name="tags[]" placeholder="{{ translate('Type & hit enter')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Images')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Main Images')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="photos" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Thumbnail Image')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="thumbnail_img" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Videos')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Video From')}}</label>
                                    <div class="col-md-10">
                                        <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity" name="video_provider">
                                            <option value="youtube">{{ translate('Youtube')}}</option>
                                            <option value="dailymotion">{{ translate('Dailymotion')}}</option>
                                            <option value="vimeo">{{ translate('Vimeo')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Video URL')}}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="video_link" placeholder="{{ translate('Video link')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Meta Tags')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Meta Title')}}</label>
                                    <div class="col-md-10">
                                        <input type="text" name="meta_title" class="form-control" placeholder="{{ translate('Meta Title')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{translate('Description')}}</label>
                                    <div class="col-md-10">
                                        <textarea name="meta_description" rows="8" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{ translate('Meta Image')}}</label>
                                    <div class="col-md-10">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="meta_img" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Price')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{ translate('Unit Price')}} <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input type="number" min="0" step="0.01" class="form-control" name="unit_price" placeholder="{{ translate('Unit Price')}} ({{ translate('Base Price')}})" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Description')}} <span class="text-danger">*</span></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{ translate('Description')}}</label>
                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <textarea class="aiz-text-editor" name="description" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('PDF Specification')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-from-label">{{ translate('PDF')}}</label>
                                    <div class="col-md-10">
                                        <div class="input-group" data-toggle="aizuploader" data-type="document">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="pdf" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mar-all text-right">
                            <button type="submit" name="button" class="btn btn-primary">{{ translate('Add New Product') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function(){
            get_subcategories_by_category();
            get_city_by_state();
            $('select[name=state_id_picker]').on('change', function(){
                get_city_by_state();
            });
        });

        $('#categories').on('change', function() {
    	    get_subcategories_by_category();
    	});

    	$('#subcategories').on('change', function() {
    	    get_subsubcategories_by_subcategory();
    	});

        function get_subcategories_by_category(el, cat_id){
            var category_id = $('#categories').val();
    		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
    		    $('#subcategories').html(null);
                console.log(data);
    		    for (var i = 0; i < data.length; i++) {
    		        $('#subcategories').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                    $(".aiz-selectpicker").selectpicker();
    		    }
    		    get_subsubcategories_by_subcategory();
    		});
        }

        function get_subsubcategories_by_subcategory(el, subcat_id){
            var subcategory_id = $('#subcategories').val();
    		$.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
    		    $('#subsubcategories').html(null);
                $('#subsubcategories').append($('<option>', {
    				value: null,
    				text: null
    			}));
    		    for (var i = 0; i < data.length; i++) {
    		        $('#subsubcategories').append($('<option>', {
    		            value: data[i].id,
    		            text: data[i].name
    		        }));
                    $(".aiz-selectpicker").selectpicker();
    		    }
    		});
        }

    </script>
@endsection
