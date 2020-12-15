@extends('backend.layouts.app')

@section('content')
	<div class="aiz-titlebar text-left mt-2 mb-3">
	    <h5 class="mb-0 h5">{{translate('Edit Digital Product')}}</h5>
	</div>
	<div class="row">
		<div class="col-lg-10 mx-auto">
			<form class="form form-horizontal mar-top" action="{{route('digitalproducts.update', $product->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
				<input name="_method" type="hidden" value="PATCH">
				<input type="hidden" name="id" value="{{ $product->id }}">
				<input type="hidden" name="lang" value="{{ $lang }}">
				@csrf
				<div class="card">
					<div class="card-body p-0">
		            	<ul class="nav nav-tabs nav-fill border-light">
		      				@foreach (\App\Language::all() as $key => $language)
		      					<li class="nav-item">
		      						<a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('digitalproducts.edit', ['id'=>$product->id, 'lang'=> $language->code] ) }}">
		      							<img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
		      							<span>{{$language->name}}</span>
		      						</a>
		      					</li>
		      		     	@endforeach
		      			</ul>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0 h6">{{translate('General')}}</h5>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Product Name')}}</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="name" placeholder="{{translate('Product Name')}}" value="{{$product->getTranslation('name', $lang)}}" required>
							</div>
						</div>
						<div class="form-group row" id="category">
							<label class="col-lg-2 col-from-label">{{translate('Category')}}</label>
							<div class="col-lg-8">
								<select class="form-control aiz-selectpicker" name="category_id" id="category_id" required>
									<option>{{translate('Select an option') }}</option>
									@foreach(\App\Category::where('digital', 1)->get() as $category)
										<option value="{{ $category->id }}" <?php if($product->category_id == $category->id) echo "selected"; ?> >{{ $category->getTranslation('name') }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row" id="subcategory">
							<label class="col-lg-2 col-from-label">{{translate('Subcategory')}}</label>
							<div class="col-lg-8">
								<select class="form-control aiz-selectpicker" name="subcategory_id" id="subcategory_id" required>

								</select>
							</div>
						</div>
						<div class="form-group row" id="subsubcategory">
							<label class="col-lg-2 col-from-label">{{translate('Sub Subcategory')}}</label>
							<div class="col-lg-8">
								<select class="form-control aiz-selectpicker" name="subsubcategory_id" id="subsubcategory_id">

								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Product File')}}</label>
							<div class="col-lg-8">
								<div class="custom-file">
									<label class="custom-file-label">
			                            <input type="file" name="file" class="custom-file-input">
			                            <span class="custom-file-name">{{ translate('Choose file') }}</span>
			                        </label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Tags')}}</label>
							<div class="col-lg-8">
								<input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags" value="{{ $product->tags }}" placeholder="{{ translate('Type to add a tag') }}">
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
				            <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Main Images')}}</label>
				            <div class="col-md-8">
				                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
				                    <div class="input-group-prepend">
				                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
				                    </div>
				                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
				                    <input type="hidden" name="photos" value="{{ $product->photos }}" class="selected-files" required>
				                </div>
				                <div class="file-preview box sm">
				                </div>
				            </div>
				        </div>

						<div class="form-group row">
				            <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}} <small>(290x300)</small></label>
				            <div class="col-md-8">
				                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
				                    <div class="input-group-prepend">
				                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
				                    </div>
				                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
				                    <input type="hidden" name="thumbnail_img" value="{{ $product->thumbnail_img }}" class="selected-files" required>
				                </div>
				                <div class="file-preview box sm">
				                </div>
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
							<label class="col-lg-2 col-from-label">{{translate('Slug')}}</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="slug" value="{{ $product->slug }}" placeholder="{{translate('Slug')}}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Meta Title')}}</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}" placeholder="{{translate('Meta Title')}}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Description')}}</label>
							<div class="col-lg-8">
								<textarea name="meta_description" rows="8" class="form-control">{{ $product->meta_description }}</textarea>
							</div>
						</div>
						<div class="form-group row">
		                    <label class="col-md-2 col-form-label" for="signinSrEmail">{{ translate('Meta Image') }}</label>
		                    <div class="col-md-8">
		                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
		                            <div class="input-group-prepend">
		                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
		                            </div>
		                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
		                            <input type="hidden" name="meta_img" value="{{ $product->meta_img }}" class="selected-files">
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
							<label class="col-lg-2 col-from-label">{{translate('Unit price')}}</label>
							<div class="col-lg-8">
								<input type="text" placeholder="{{translate('Unit price')}}" name="unit_price" class="form-control" value="{{$product->unit_price}}" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Purchase price')}}</label>
							<div class="col-lg-8">
								<input type="number" min="0" step="0.01" placeholder="{{translate('Purchase price')}}" name="purchase_price" class="form-control" value="{{$product->purchase_price}}" required>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Tax')}}</label>
							<div class="col-lg-6">
								<input type="number" min="0" step="0.01" placeholder="{{translate('tax')}}" name="tax" class="form-control" value="{{$product->tax}}" required>
							</div>
							<div class="col-md-2">
								<select class="form-control aiz-selectpicker" name="tax_type" required>
									<option value="amount" <?php if($product->tax_type == 'amount') echo "selected";?> >{{translate('Flat')}}</option>
									<option value="percent" <?php if($product->tax_type == 'percent') echo "selected";?> >{{translate('Percent')}}</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Discount')}}</label>
							<div class="col-lg-6">
								<input type="number" min="0" step="0.01" placeholder="{{translate('Discount')}}" name="discount" class="form-control" value="{{ $product->discount }}" required>
							</div>
							<div class="col-lg-2">
								<select class="form-control aiz-selectpicker" name="discount_type" required>
									<option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?> >{{translate('Flat')}}</option>
									<option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?> >{{translate('Percent')}}</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5 class="mb-0 h6">{{translate('Description')}}</h5>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<label class="col-lg-2 col-from-label">{{translate('Description')}}</label>
							<div class="col-lg-9">
								<textarea class="aiz-text-editor" name="description">{{ $product->getTranslation('description', $lang) }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
			</div>
		</form>
	</div>

@endsection

@section('script')

	<script type="text/javascript">

	function get_subcategories_by_category(){
		var category_id = $('#category_id').val();
		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
			$('#subcategory_id').html(null);
			for (var i = 0; i < data.length; i++) {
				$('#subcategory_id').append($('<option>', {
					value: data[i].id,
					text: data[i].name
				}));
			}
			$("#subcategory_id > option").each(function() {
				if(this.value == '{{$product->subcategory_id}}'){
					$("#subcategory_id").val(this.value).change();
				}
			});

			AIZ.plugins.bootstrapSelect('refresh');

			get_subsubcategories_by_subcategory();
		});
	}

	function get_subsubcategories_by_subcategory(){
		var subcategory_id = $('#subcategory_id').val();
		$.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
			$('#subsubcategory_id').html(null);
			for (var i = 0; i < data.length; i++) {
				$('#subsubcategory_id').append($('<option>', {
					value: data[i].id,
					text: data[i].name
				}));
			}
			$("#subsubcategory_id > option").each(function() {
				if(this.value == '{{$product->subsubcategory_id}}'){
					$("#subsubcategory_id").val(this.value).change();
				}
			});

			AIZ.plugins.bootstrapSelect('refresh');
		});
	}

	// function get_brands_by_subsubcategory(){
	// 	var subsubcategory_id = $('#subsubcategory_id').val();
	// 	$.post('{{ route('subsubcategories.get_brands_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
	// 		$('#brand_id').html(null);
	// 		for (var i = 0; i < data.length; i++) {
	// 			$('#brand_id').append($('<option>', {
	// 				value: data[i].id,
	// 				text: data[i].name
	// 			}));
	// 		}
	// 		$("#brand_id > option").each(function() {
	// 			if(this.value == '{{$product->brand_id}}'){
	// 				$("#brand_id").val(this.value).change();
	// 			}
	// 		});
	// 		AIZ.plugins.bootstrapSelect('refresh');
	// 	});
	// }

	$(document).ready(function(){
		$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
		get_subcategories_by_category();
	});

	$('#category_id').on('change', function() {
		get_subcategories_by_category();
	});

	$('#subcategory_id').on('change', function() {
		get_subsubcategories_by_subcategory();
	});

	// $('#subsubcategory_id').on('change', function() {
	// 	get_brands_by_subsubcategory();
	// });

</script>

@endsection
