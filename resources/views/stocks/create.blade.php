@extends('layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Product Stock Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('stocks.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="name">{{__('Category')}}</label>
                    <div class="col-lg-9">
                        <select name="category_id" id="category_id" class="form-control demo-select2-placeholder" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{__($category->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="name">{{__('Subcategory')}}</label>
                    <div class="col-lg-9">
                        <select name="subcategory_id" id="subcategory_id" class="form-control demo-select2-placeholder" required>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="name">{{__('Sub Subcategory')}}</label>
                    <div class="col-lg-9">
                        <select name="subsubcategory_id" id="subsubcategory_id" class="form-control demo-select2-placeholder" required>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="name">{{__('Product')}}</label>
                    <div class="col-lg-9">
                        <select name="product_id" id="product_id" class="form-control demo-select2-placeholder" required>

                        </select>
                    </div>
                </div>
            </div>

            <div class="panel-heading">
                <h3 class="panel-title">{{__('SKU')}}</h3>
            </div>

            <div class="panel-body">

                <div class="stock_info" id="stock_info">

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
                $('.demo-select2').select2();
            }
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
                $('.demo-select2').select2();
            }
            get_products_by_subsubcategory();
        });
    }

    function get_products_by_subsubcategory(){
        var subsubcategory_id = $('#subsubcategory_id').val();
        $.post('{{ route('products.get_products_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
            $('#product_id').html(null);
            for (var i = 0; i < data.length; i++) {
                $('#product_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
                $('.demo-select2').select2();
            }
            get_sku_combinations();
        });
    }

    function get_sku_combinations(){
        var subsubcategory_id = $('#subsubcategory_id').val();
        var product_id = $('#product_id').val();
        $.post('{{ route('stocks.sku_combinations') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id, product_id:product_id}, function(data){
            $('#stock_info').html(data);

                $('.color').spectrum({
                    preferredFormat: "hex",
                    showPalette: false
                });
        });
    }

    $(document).ready(function(){
        get_subcategories_by_category();
    });

    $('#category_id').on('change', function() {
        get_subcategories_by_category();
    });

    $('#subcategory_id').on('change', function() {
        get_subsubcategories_by_subcategory();
    });

    $('#subsubcategory_id').on('change', function() {
        get_products_by_subsubcategory();
    });

</script>

@endsection
