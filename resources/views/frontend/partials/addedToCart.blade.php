<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-success">
        <i class="fa fa-check"></i>
        <h3>{{__('Item added to your cart!')}}</h3>
    </div>
    <div class="product-box">
        <div class="block">
            <div class="block-image">
                <img src="{{ asset($product->thumbnail_img) }}" class="" alt="Product Image">
            </div>
            <div class="block-body">
                <h6 class="strong-600">
                    {{ __($product->name) }}
                </h6>
                <div class="row no-gutters mt-2 mb-2">
                    <div class="col-2">
                        <div>{{__('Price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="heading-6 text-danger">
                            <strong>
                                {{ single_price($data['price']*$data['quantity']) }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-styled btn-base-1 btn-outline mb-3 mb-sm-0" data-dismiss="modal">{{__('Back to shopping')}}</button>
        <a href="{{ route('cart') }}" class="btn btn-styled btn-base-1 mb-3 mb-sm-0">{{__('Proceed to Checkout')}}</a>
    </div>
</div>
