<div class="modal-body p-4">
    <div class="row no-gutters cols-xs-space cols-sm-space cols-md-space">
        <div class="col-lg-6">
            <div class="product-gal d-flex flex-row-reverse">
                <div class="product-gal-img">
                    <img class="xzoom img-fluid" src="{{ asset(json_decode($product->photos)[0]) }}" xoriginal="{{ asset(json_decode($product->photos)[0]) }}" />
                </div>
                <div class="product-gal-thumb">
                    <div class="xzoom-thumbs">
                        @foreach (json_decode($product->photos) as $key => $photo)
                            <a href="{{ asset($photo) }}">
                                <img class="xzoom-gallery" width="80" src="{{ asset($photo) }}"  @if($key == 0) xpreview="{{ asset($photo) }}" @endif>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Product description -->
            <div class="product-description-wrapper">
                <!-- Product title -->
                <h2 class="product-title">
                    {{ __($product->name) }}
                </h2>

                <div class="row no-gutters mt-4">
                    <div class="col-2">
                        <div class="product-description-label">{{__('Price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price-old">
                            <del>
                                {{ home_price($product->id) }}
                                <span>/{{ $product->unit }}</span>
                            </del>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters mt-3">
                    <div class="col-2">
                        <div class="product-description-label">{{__('Discount Price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong>
                                {{ home_discounted_price($product->id) }}
                            </strong>
                            <span class="piece">/{{ $product->unit }}</span>
                        </div>
                    </div>
                </div>

                <hr>

                <form id="option-choice-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">

                    @foreach (json_decode($product->choice_options) as $key => $choice)

                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="product-description-label">{{ $choice->title }}:</div>
                        </div>
                        <div class="col-10">
                            <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2">
                                @foreach ($choice->options as $key => $option)
                                    <li>
                                        <input type="radio" id="{{ $choice->name }}-{{ $option }}" name="{{ $choice->name }}" value="{{ $option }}">
                                        <label for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @endforeach

                    @if(count(json_decode($product->colors)) > 0)
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="product-description-label">{{__('Color')}}:</div>
                            </div>
                            <div class="col-10">
                                <ul class="list-inline checkbox-color mb-1">
                                    @foreach (json_decode($product->colors) as $key => $color)
                                        <li>
                                            <input type="radio" id="{{ $product->id }}-color-{{ $key }}" name="color" value="{{ $color }}">
                                            <label style="background: {{ $color }};" for="{{ $product->id }}-color-{{ $key }}" data-toggle="tooltip"></label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <hr>

                    <!-- Quantity + Add to cart -->
                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="product-description-label mt-2">{{__('Quantity')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="input-group input-group--style-2 pr-3" style="width: 160px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                            <i class="la la-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quantity" class="form-control input-number text-center" placeholder="1" value="1" min="1" max="10">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button" data-type="plus" data-field="quantity">
                                            <i class="la la-plus"></i>
                                        </button>
                                    </span>
                                </div>
                                {{-- <div class="avialable-amount">(1298 pc available)</div> --}}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                        <div class="col-2">
                            <div class="product-description-label">{{__('Total Price')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-price">
                                <strong id="chosen_price">

                                </strong>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="d-table width-100 mt-3">
                    <div class="d-table-cell">
                        <!-- Add to cart button -->
                        <button type="button" class="btn btn-base-1 btn-icon-left" onclick="addToCart()">
                            <i class="icon ion-bag"></i> {{__('Add to cart')}}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    cartQuantityInitialize();
    $('#option-choice-form input').on('change', function(){
        getVariantPrice();
    });
</script>
