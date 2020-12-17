@extends('frontend.layouts.app')

@section('content')

<div class="all-category-wrap py-4 gry-bg">
    <div class="sticky-top">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-white all-category-menu">
                        <ul class="clearfix no-scrollbar">
                            @if(count($categories) > 12)
                                @for ($i = 0; $i < 11; $i++)
                                    <li class="@php if($i == 0) echo 'active' @endphp">
                                        <a href="#{{ $i }}" class="row no-gutters align-items-center">
                                            <div class="col-md-3">
                                                <img class="cat-image" src="{{ asset($categories[$i]->icon) }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="cat-name">{{ $categories[$i]->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endfor
                                <li class="">
                                    <a href="#more" class="row no-gutters align-items-center">
                                        <div class="col-md-3">
                                            <i class="fa fa-ellipsis-h cat-icon"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="cat-name">{{__('More Categories')}}</div>
                                        </div>
                                    </a>
                                </li>
                            @else
                                @foreach ($categories as $key => $category)
                                    <li class="@php if($key == 0) echo 'active' @endphp">
                                        <a href="#{{ $key }}" class="row no-gutters align-items-center">
                                            <div class="col-md-3">
                                                <img class="cat-image" src="{{ asset($category->icon) }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="cat-name">{{ __($category->name) }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-white">
                        @foreach ($categories as $key => $category)
                            @php
                                $brands = array();
                            @endphp
                            @if(count($categories)>12 && $key == 11)
                                <div class="sub-category-menu active" id="more">
                                    <h3 class="category-name"><a href="{{ route('products.category', $category->id) }}">{{ __($category->name) }}</a></h3>
                                    <ul>
                                        @foreach ($category->subcategories as $key => $subcategory)
                                            @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                                                @php
                                                    foreach (json_decode($subsubcategory->brands) as $brand) {
                                                        if(!in_array($brand, $brands)){
                                                            array_push($brands, $brand);
                                                        }
                                                    }
                                                @endphp
                                            @endforeach
                                        @endforeach

                                        @foreach ($brands as $brand_id)
                                            @if(\App\Brand::find($brand_id) != null)
                                                <li class="brand-box">
                                                    <a href="{{ route('products.brand', $brand_id) }}">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-xl-4 col-5">
                                                                <div class="img">
                                                                    <img src="{{ asset(\App\Brand::find($brand_id)->logo) }}" class="img-fluid">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-8 col-7">
                                                                <div class="text-truncate name">{{ __(\App\Brand::find($brand_id)->name) }}</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <div class="sub-category-menu @php if($key < 12) echo 'active'; @endphp" id="{{ $key }}">
                                    <h3 class="category-name"><a href="{{ route('products.category', $category->id) }}" >{{ __($category->name) }}</a></h3>
                                    <ul>
                                        @foreach ($category->subcategories as $key => $subcategory)
                                            @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                                                @php
                                                    foreach (json_decode($subsubcategory->brands) as $brand) {
                                                        if(!in_array($brand, $brands)){
                                                            array_push($brands, $brand);
                                                        }
                                                    }
                                                @endphp
                                            @endforeach
                                        @endforeach
                                        @foreach ($brands as $brand_id)
                                            @if(\App\Brand::find($brand_id) != null)
                                                <li class="brand-box">
                                                    <a href="{{ route('products.brand', $brand_id) }}">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col-xl-4 col-5">
                                                                <div class="img">
                                                                    <img src="{{ asset(\App\Brand::find($brand_id)->logo) }}" class="img-fluid">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-8 col-7">
                                                                <div class="text-truncate name">{{ __(\App\Brand::find($brand_id)->name) }}</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
