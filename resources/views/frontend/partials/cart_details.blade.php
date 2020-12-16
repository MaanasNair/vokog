<div class="container">
    <div class="row cols-xs-space cols-sm-space cols-md-space">
        <div class="col-xl-8">
            <!-- <form class="form-default bg-white p-4" data-toggle="validator" role="form"> -->
            <div class="form-default bg-white p-4">
                <div class="">
                    <div class="">
                        <table class="table-cart border-bottom">
                            <thead>
                                <tr>
                                    <th class="product-image"></th>
                                    <th class="product-name">{{__('Product')}}</th>
                                    <th class="product-price d-none d-lg-table-cell">{{__('Price')}}</th>
                                    <th class="product-quanity d-none d-md-table-cell">{{__('Quantity')}}</th>
                                    <th class="product-total">{{__('Total')}}</th>
                                    <th class="product-remove"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0;
                                @endphp
                                @foreach (Session::get('cart') as $key => $cartItem)
                                    @php
                                    $product = \App\Product::find($cartItem['id']);
                                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                                    $product_name_with_choice = $product->name;
                                    if(isset($cartItem['color'])){
                                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                                    }
                                    foreach (json_decode($product->choice_options) as $choice){
                                        $str = $choice->name; // example $str =  choice_0
                                        $product_name_with_choice .= ' - '.$cartItem[$str];
                                    }
                                    @endphp
                                    <tr class="cart-item">
                                        <td class="product-image">
                                            <a href="#" class="mr-3">
                                                <img src="{{ asset($product->thumbnail_img) }}">
                                            </a>
                                        </td>

                                        <td class="product-name">
                                            <span class="pr-4 d-block">{{ $product_name_with_choice }}</span>
                                        </td>

                                        <td class="product-price d-none d-lg-table-cell">
                                            <span class="pr-3 d-block">{{ single_price($cartItem['price']) }}</span>
                                        </td>

                                        <td class="product-quantity d-none d-md-table-cell">
                                            <div class="input-group input-group--style-2 pr-4" style="width: 130px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="minus" data-field="quantity[{{ $key }}]">
                                                        <i class="la la-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity[{{ $key }}]" class="form-control input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="10" onchange="updateQuantity({{ $key }}, this)">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="plus" data-field="quantity[{{ $key }}]">
                                                        <i class="la la-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="product-total">
                                            <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                        </td>
                                        <td class="product-remove">
                                            <a href="#" onclick="removeFromCartView(event, {{ $key }})" class="text-right pl-4">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row align-items-center pt-4">
                    <div class="col-6">
                        <a href="{{ route('home') }}" class="link link--style-3">
                            <i class="ion-android-arrow-back"></i>
                            {{__('Return to shop')}}
                        </a>
                    </div>
                    <div class="col-6 text-right">
                        @if(Auth::check())
                            <a href="{{ route('checkout.shipping_info') }}" class="btn btn-styled btn-base-1">{{__('Continue to Shipping')}}</a>
                        @else
                            <button class="btn btn-styled btn-base-1" onclick="showCheckoutModal()">{{__('Continue to Shipping')}}</button>
                        @endif
                    </div>
                </div>
            </div>
            <!-- </form> -->
        </div>

        <div class="col-xl-4 ml-lg-auto">
            @include('frontend.partials.cart_summary')
        </div>
    </div>
</div>

<script type="text/javascript">
    cartQuantityInitialize();
</script>
