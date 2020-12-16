@extends('frontend.layouts.app')

@section('content')
    <!-- <section>
        <img src="https://via.placeholder.com/2000x300.jpg" alt="" class="img-fluid">
    </section> -->

    <section class="gry-bg pt-4 ">
        <div class="container">
            <div class="row align-items-baseline">
                <div class="col-md-6">
                    <div class="d-flex">
                        <img height="60" src="{{ asset($shop->logo) }}" alt="Shop Logo">
                        <div class="pl-4">
                            <h3 class="strong-700 heading-4 mb-0 mt-2">{{ $shop->name }}
                                @if ($shop->user->seller->verification_status == 1)
                                    <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span>
                                @else
                                    <span class="ml-2"><i class="fa fa-times-circle" style="color:red"></i></span>
                                @endif
                            </h3>
                            <div class="location alpha-6">{{ $shop->address }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="text-md-right mt-4 mt-md-0 social-nav model-2">
                        <li>
                            <a href="{{ $shop->facebook }}" class="facebook social_a" target="_blank" data-toggle="tooltip" data-original-title="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $shop->google }}" class="google-plus social_a" target="_blank" data-toggle="tooltip" data-original-title="Google">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $shop->twitter }}" class="twitter social_a" target="_blank" data-toggle="tooltip" data-original-title="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $shop->youtube }}" class="youtube social_a" target="_blank" data-toggle="tooltip" data-original-title="Youtube">
                                <i class="fa fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row sticky-top mt-4">
                <div class="col">
                    <div class="seller-shop-menu">
                        <ul class="inline-links">
                            <li @if(!isset($type)) class="active" @endif><a href="{{ route('shop.visit', $shop->slug) }}">{{__('Store Home')}}</a></li>
                            <li @if(isset($type) && $type == 'top_selling') class="active" @endif><a href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'top_selling']) }}">{{__('Top Selling')}}</a></li>
                            <li @if(isset($type) && $type == 'all_products') class="active" @endif><a href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'all_products']) }}">{{__('All Products')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!isset($type))
        <section class="py-5">
            <div class="container">
                <div class="home-slide">
                    <div class="slick-carousel" data-slick-arrows="true" data-slick-dots="true">
                        @if ($shop->sliders != null)
                            @foreach (json_decode($shop->sliders) as $key => $slide)
                                <div class="">
                                    <img class="d-block w-100" src="{{ asset($slide) }}" alt="{{ $key }} slide" style="max-height:300px;">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section class="slice sct-color-1 pt-2">
            <div class="container">
                <div class="section-title section-title--style-1 text-center mb-5">
                    <h3 class="section-title-inner heading-3 strong-600">
                        {{__('Featured Products')}}
                    </h3>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="caorusel-box">
                            <div class="slick-carousel center-mode" data-slick-items="5" data-slick-lg-items="3"  data-slick-md-items="3" data-slick-sm-items="1" data-slick-xs-items="1" data-slick-center="true">
                                @foreach ($shop->user->products->where('published', 1)->where('featured', 1) as $key => $product)
                                    <div class="">
                                        <div class="product-card-2 card card-product mx-3 my-5 shop-cards shop-tech">
                                            <div class="card-body p-0">

                                                <div class="card-image">
                                                    <a href="{{ route('product', $product->slug) }}" class="d-block" style="background-image:url('{{ asset($product->featured_img) }}');">
                                                    </a>
                                                </div>

                                                <div class="p-3">
                                                    <div class="price-box">
                                                        <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                        <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                    </div>
                                                    <h2 class="product-title p-0 mt-2 text-truncate-2">
                                                        <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    @endif


    <section class="@if (!isset($type)) gry-bg @endif pt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="seller-info-box mb-3">
                        <div class="sold-by position-relative">
                            @if($shop->user->seller->verification_status == 1)
                                <div class="position-absolute medal-badge">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 287.5 442.2">
                                        <polygon style="fill:#F8B517;" points="223.4,442.2 143.8,376.7 64.1,442.2 64.1,215.3 223.4,215.3 "/>
                                        <circle style="fill:#FBD303;" cx="143.8" cy="143.8" r="143.8"/>
                                        <circle style="fill:#F8B517;" cx="143.8" cy="143.8" r="93.6"/>
                                        <polygon style="fill:#FCFCFD;" points="143.8,55.9 163.4,116.6 227.5,116.6 175.6,154.3 195.6,215.3 143.8,177.7 91.9,215.3 111.9,154.3
                                        60,116.6 124.1,116.6 "/>
                                    </svg>
                                </div>
                            @endif
                            <div class="title">{{__('Seller Info')}}</div>
                            <a href="" class="name d-block">{{ $shop->name }}</a>
                            <div class="location">{{ $shop->address }}</div>
                            <div class="rating text-center d-block">
                                <span class="star-rating star-rating-sm d-block">
                                    @php
                                        $rating = 0; $total = 0;
                                        foreach ($shop->user->products as $key => $seller_product) {
                                            $rating += $seller_product->reviews->sum('rating');
                                            $total += $seller_product->reviews->count();
                                        }
                                    @endphp
                                    @if ($total > 0)
                                        @for ($i=0; $i < floor($rating/$total); $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                        @for ($i=0; $i < ceil(5-$rating/$total); $i++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                    @endif
                                </span>
                                <span class="rating-count d-block ml-0">({{ $total }} {{__('customer reviews')}})</span>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col">
                                <ul class="social-media social-media--style-1-v4 text-center">
                                    <li>
                                        <a href="{{ $shop->facebook }}" class="facebook" target="_blank" data-toggle="tooltip" data-original-title="Facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $shop->google }}" class="google" target="_blank" data-toggle="tooltip" data-original-title="Google">
                                            <i class="fa fa-google"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $shop->twitter }}" class="twitter" target="_blank" data-toggle="tooltip" data-original-title="Twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $shop->youtube }}" class="youtube" target="_blank" data-toggle="tooltip" data-original-title="Youtube">
                                            <i class="fa fa-youtube"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="seller-category-box bg-white sidebar-box mb-3">
                        <div class="box-title">
                            {{__('This Sellers Categories')}}
                        </div>
                        <div class="box-content">
                            <div class="category-accordion">
                                @php
                                    $brands = array();
                                @endphp
                                @foreach (\App\Product::where('user_id', $shop->user->id)->select('category_id')->distinct()->get() as $key => $category)
                                    <div class="single-category">
                                        <button class="btn w-100 category-name collapsed" type="button" data-toggle="collapse" data-target="#category-{{ $key }}" aria-expanded="false">
                                        {{ App\Category::findOrFail($category->category_id)->name }}
                                        </button>

                                        <div id="category-{{ $key }}" class="collapse">
                                            @foreach (\App\Product::where('user_id', $shop->user->id)->where('category_id', $category->category_id)->select('subcategory_id')->distinct()->get() as $subcategory)
                                                <div class="single-sub-category">
                                                    <button class="btn w-100 sub-category-name" type="button" data-toggle="collapse" data-target="#subCategory-{{ $subcategory->subcategory_id }}" aria-expanded="false">
                                                    {{ App\SubCategory::findOrFail($subcategory->subcategory_id)->name }}
                                                    </button>
                                                    <div id="subCategory-{{ $subcategory->subcategory_id }}" class="collapse">
                                                        <ul class="sub-sub-category-list">
                                                            @foreach (\App\Product::where('user_id', $shop->user->id)->where('category_id',            $category->category_id)->where('subcategory_id', $subcategory->subcategory_id)->select('subsubcategory_id')->distinct()->get() as $subsubcategory)
                                                                @php
                                                                    $subsubcategory = App\SubSubCategory::findOrFail($subsubcategory->subsubcategory_id);
                                                                    foreach (json_decode($subsubcategory->brands) as $brand) {
                                                                        if(!in_array($brand, $brands)){
                                                                            array_push($brands, $brand);
                                                                        }
                                                                    }
                                                                @endphp
                                                                <li><a href="{{ route('products.subsubcategory', $subsubcategory->id) }}">{{__($subsubcategory->name) }}</a></li>
                                                            @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="seller-top-products-box bg-white sidebar-box mb-4">
                        <div class="box-title">
                            {{__('Brands')}}
                        </div>
                        <div class="box-content">
                            <div class="seller-brands">
                        		<ul class="seller-brand-list">
                                    @foreach ($brands as $brand_id)
                                        <li class="brand-item">
                                            <a href="{{ route('products.brand', $brand_id) }}"><img src="{{ asset(\App\Brand::find($brand_id)->logo) }}" class="img-fluid"></a>
                                        </li>
                                    @endforeach
                        		</ul>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <h4 class="heading-5 strong-600 border-bottom pb-3 mb-4">
                        @if (!isset($type))
                            {{__('New Arrival Products')}}
                        @elseif ($type == 'top_selling')
                            {{__('Top Selling')}}
                        @elseif ($type == 'all_products')
                            {{__('All Products')}}
                        @endif
                    </h4>
                    <div class="product-list row">
                        @php
                            if (!isset($type)){
                                $products = \App\Product::where('user_id', $shop->user->id)->where('published', 1)->orderBy('created_at', 'desc')->paginate(6);
                            }
                            elseif ($type == 'top_selling'){
                                $products = \App\Product::where('user_id', $shop->user->id)->where('published', 1)->orderBy('num_of_sale', 'desc')->paginate(6);
                            }
                            elseif ($type == 'all_products'){
                                $products = \App\Product::where('user_id', $shop->user->id)->where('published', 1)->paginate(6);
                            }
                        @endphp
                        @foreach ($products as $key => $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="card product-box-1 mb-3">
                                    <div class="card-image">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block" style="background-image:url('{{ asset($product->thumbnail_img) }}');" tabindex="0">
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="title p-3 text-truncate-2">
                                            <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                        </div>
                                        <div class="price-bar row no-gutters">
                                            <div class="price col-8">
                                                @if(home_price($product->id) != home_discounted_price($product->id))
                                                    <del class="old-product-price strong-600">{{ home_base_price($product->id) }}</del>
                                                    <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                @else
                                                    <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                @endif
                                            </div>
                                            <div class="col-4">
                                                <button class="add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})">
                                                    <i class="ion-ios-heart-outline"></i>
                                                </button>
                                                <button class="add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})">
                                                    <i class="ion-ios-browsers-outline"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="cart-add">
                                            <button type="button" class=" btn btn-block btn-icon-left" onclick="showAddToCartModal({{ $product->id }})">
                                                <i class="icon ion-android-cart"></i>{{__('Add to cart')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="products-pagination my-5">
                                <nav aria-label="Center aligned pagination">
                                    <ul class="pagination justify-content-center">
                                        {{ $products->links() }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
