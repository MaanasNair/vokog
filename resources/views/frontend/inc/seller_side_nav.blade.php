<div class="sidebar sidebar--style-3 no-border stickyfill p-0">
    <div class="widget mb-0">
        <div class="widget-profile-box text-center p-3">
            @if (Auth::user()->avatar_original != null)
                <div class="image" style="background-image:url('{{ uploaded_asset(Auth::user()->avatar_original) }}')"></div>
            @else
                <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle">
            @endif
            @if(Auth::user()->seller->verification_status == 1)
                <div class="name mb-0">{{ Auth::user()->name }} <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span></div>
            @else
                <div class="name mb-0">{{ Auth::user()->name }} <span class="ml-2"><i class="fa fa-times-circle" style="color:red"></i></span></div>
            @endif
        </div>
        <div class="sidebar-widget-title py-3">
            <span>{{ translate('Menu')}}</span>
        </div>
        <div class="widget-profile-menu py-3">
            <ul class="categories categories--style-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ areActiveRoutesHome(['dashboard'])}}">
                        <i class="la la-dashboard"></i>
                        <span class="category-name">
                            {{ translate('Dashboard')}}
                        </span>
                    </a>
                </li>
                @php
                    $delivery_viewed = App\Order::where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
                    $payment_status_viewed = App\Order::where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
                    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                    $club_point_addon = \App\Addon::where('unique_identifier', 'club_point')->first();
                @endphp
                <li>
                    <a href="{{ route('purchase_history.index') }}" class="{{ areActiveRoutesHome(['purchase_history.index'])}}">
                        <i class="la la-file-text"></i>
                        <span class="category-name">
                            {{ translate('Purchase History')}} @if($delivery_viewed > 0 || $payment_status_viewed > 0)<span class="ml-2" style="color:green"><strong>({{  translate(' New Notifications') }})</strong></span>@endif
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('digital_purchase_history.index') }}" class="{{ areActiveRoutesHome(['digital_purchase_history.index'])}}">
                        <i class="la la-download"></i>
                        <span class="category-name">
                            {{ translate('Downloads')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('wishlists.index') }}" class="{{ areActiveRoutesHome(['wishlists.index'])}}">
                        <i class="la la-heart-o"></i>
                        <span class="category-name">
                            {{ translate('Wishlist')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('seller.products') }}" class="{{ areActiveRoutesHome(['seller.products', 'seller.products.upload', 'seller.products.edit'])}}">
                        <i class="la la-diamond"></i>
                        <span class="category-name">
                            {{ translate('Products')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('seller.digitalproducts') }}" class="{{ areActiveRoutesHome(['seller.digitalproducts', 'seller.digitalproducts.upload', 'seller.digitalproducts.edit'])}}">
                        <i class="la la-diamond"></i>
                        <span class="category-name">
                            {{ translate('Digital Products')}}
                        </span>
                    </a>
                </li>
                @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                <li>
                    <a href="{{ route('customer_products.index') }}" class="{{ areActiveRoutesHome(['customer_products.index', 'customer_products.create', 'customer_products.edit'])}}">
                        <i class="la la-diamond"></i>
                        <span class="category-name">
                            {{ translate('Classified Products')}}
                        </span>
                    </a>
                </li>
                @endif
                @if (\App\Addon::where('unique_identifier', 'pos_system')->first() != null && \App\Addon::where('unique_identifier', 'pos_system')->first()->activated)
                    @if (\App\BusinessSetting::where('type', 'pos_activation_for_seller')->first() != null && \App\BusinessSetting::where('type', 'pos_activation_for_seller')->first()->value != 0)
                        <li>
                            <a href="{{route('poin-of-sales.seller_index')}}" class="{{ areActiveRoutesHome(['poin-of-sales.seller_index'])}}">
                                <i class="la la-fax"></i>
                                <span class="category-name">
                                    {{ translate('POS Manager')}}
                                </span>
                            </a>
                        </li>
                    @endif
                @endif
                <li>
                    <a href="{{route('product_bulk_upload.index')}}" class="{{ areActiveRoutesHome(['product_bulk_upload.index'])}}">
                        <i class="la la-upload"></i>
                        <span class="category-name">
                            {{ translate('Product Bulk Upload')}}
                        </span>
                    </a>
                </li>
                @php
                    $orders = DB::table('orders')
                                ->orderBy('code', 'desc')
                                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                ->where('order_details.seller_id', Auth::user()->id)
                                ->where('orders.viewed', 0)
                                ->select('orders.id')
                                ->distinct()
                                ->count();
                @endphp
                <li>
                    <a href="{{ route('orders.index') }}" class="{{ areActiveRoutesHome(['orders.index'])}}">
                        <i class="la la-file-text"></i>
                        <span class="category-name">
                            {{ translate('Orders')}} @if($orders > 0)<span class="ml-2" style="color:green"><strong>({{ $orders }} {{  translate('New') }})</strong></span></span>@endif
                        </span>
                    </a>
                </li>

                @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <li>
                        <a href="{{ route('vendor_refund_request') }}" class="{{ areActiveRoutesHome(['vendor_refund_request'])}}">
                            <i class="la la-file-text"></i>
                            <span class="category-name">
                                {{ translate('Recieved Refund Request')}}
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('customer_refund_request') }}" class="{{ areActiveRoutesHome(['customer_refund_request'])}}">
                            <i class="la la-file-text"></i>
                            <span class="category-name">
                                {{ translate('Sent Refund Request')}}
                            </span>
                        </a>
                    </li>
                @endif

                @php
                    $review_count = DB::table('reviews')
                                ->orderBy('code', 'desc')
                                ->join('products', 'products.id', '=', 'reviews.product_id')
                                ->where('products.user_id', Auth::user()->id)
                                ->where('reviews.viewed', 0)
                                ->select('reviews.id')
                                ->distinct()
                                ->count();
                @endphp
                <li>
                    <a href="{{ route('reviews.seller') }}" class="{{ areActiveRoutesHome(['reviews.seller'])}}">
                        <i class="la la-star-o"></i>
                        <span class="category-name">
                            {{ translate('Product Reviews')}}@if($review_count > 0)<span class="ml-2" style="color:green"><strong>({{ $review_count }} {{  translate('New') }})</strong></span>@endif
                        </span>
                    </a>
                </li>
                @if (\App\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                    @php
                        $conversation_sent = \App\Conversation::where('sender_id', Auth::user()->id)->where('sender_viewed', 0)->get();
                        $conversation_recieved = \App\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', 0)->get();
                    @endphp
                    <li>
                        <a href="{{ route('conversations.index') }}" class="{{ areActiveRoutesHome(['conversations.index', 'conversations.show'])}}">
                            <i class="la la-comment"></i>
                            <span class="category-name">
                                {{ translate('Conversations')}}
                                @if (count($conversation_sent)+count($conversation_recieved) > 0)
                                    <span class="ml-2" style="color:green"><strong>({{ count($conversation_sent)+count($conversation_recieved) }})</strong></span>
                                @endif
                            </span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('shops.index') }}" class="{{ areActiveRoutesHome(['shops.index'])}}">
                        <i class="la la-cog"></i>
                        <span class="category-name">
                            {{ translate('Shop Setting')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('payments.index') }}" class="{{ areActiveRoutesHome(['payments.index'])}}">
                        <i class="la la-cc-mastercard"></i>
                        <span class="category-name">
                            {{ translate('Payment History')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}" class="{{ areActiveRoutesHome(['profile'])}}">
                        <i class="la la-user"></i>
                        <span class="category-name">
                            {{ translate('Manage Profile')}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('withdraw_requests.index') }}" class="{{ areActiveRoutesHome(['withdraw_requests.index'])}}">
                        <i class="la la-money"></i>
                        <span class="category-name">
                            {{ translate('Money Withdraw')}}
                        </span>
                    </a>
                </li>
                @if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                    <li>
                        <a href="{{ route('wallet.index') }}" class="{{ areActiveRoutesHome(['wallet.index'])}}">
                            <i class="la la-dollar"></i>
                            <span class="category-name">
                                {{ translate('My Wallet')}}
                            </span>
                        </a>
                    </li>
                @endif
                @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                    <li>
                        <a href="{{ route('affiliate.user.index') }}" class="{{ areActiveRoutesHome(['affiliate.user.index', 'affiliate.payment_settings'])}}">
                            <i class="la la-dollar"></i>
                            <span class="category-name">
                                {{ translate('Affiliate System')}}
                            </span>
                        </a>
                    </li>
                @endif
                @if ($club_point_addon != null && $club_point_addon->activated == 1)
                    <li>
                        <a href="{{ route('earnng_point_for_user') }}" class="{{ areActiveRoutesHome(['earnng_point_for_user'])}}">
                            <i class="la la-dollar"></i>
                            <span class="category-name">
                                {{ translate('Earning Points')}}
                            </span>
                        </a>
                    </li>
                @endif
                @php
                    $support_ticket = DB::table('tickets')
                                ->where('client_viewed', 0)
                                ->where('user_id', Auth::user()->id)
                                ->count();
                @endphp
                <li>
                    <a href="{{ route('support_ticket.index') }}" class="{{ areActiveRoutesHome(['support_ticket.index', 'support_ticket.show'])}}">
                        <i class="la la-support"></i>
                        <span class="category-name">
                            {{ translate('Support Ticket')}} @if($support_ticket > 0)<span class="ml-2" style="color:green"><strong>({{ $support_ticket }} {{  translate('New') }})</strong></span></span>@endif
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-widget-title py-3">
            <span>{{ translate('Sold Amount')}}</span>
        </div>
        <div class="widget-balance pb-3 pt-1">
            <div class="text-center">
                <div class="heading-4 strong-700 mb-4">
                    @php
                        $orderDetails = \App\OrderDetail::where('seller_id', Auth::user()->id)->where('created_at', '>=', date('-30d'))->get();
                        $total = 0;
                        foreach ($orderDetails as $key => $orderDetail) {
                            if($orderDetail->order->payment_status == 'paid'){
                                $total += $orderDetail->price;
                            }
                        }
                    @endphp
                    <small class="d-block text-sm alpha-5 mb-2">{{ translate('Your sold amount (current month)')}}</small>
                    <span class="p-2 bg-base-1 rounded">{{ single_price($total) }}</span>
                </div>
                <table class="text-left mb-0 table w-75 m-auto">
                    <tr>
                        @php
                            $orderDetails = \App\OrderDetail::where('seller_id', Auth::user()->id)->get();
                            $total = 0;
                            foreach ($orderDetails as $key => $orderDetail) {
                                if($orderDetail->order->payment_status == 'paid'){
                                    $total += $orderDetail->price;
                                }
                            }
                        @endphp
                        <td class="p-1 text-sm">
                            {{ translate('Total Sold')}}:
                        </td>
                        <td class="p-1">
                            {{ single_price($total) }}
                        </td>
                    </tr>
                    <tr>
                        @php
                            $orderDetails = \App\OrderDetail::where('seller_id', Auth::user()->id)->where('created_at', '>=', date('-60d'))->where('created_at', '<=', date('-30d'))->get();
                            $total = 0;
                            foreach ($orderDetails as $key => $orderDetail) {
                                if($orderDetail->order->payment_status == 'paid'){
                                    $total += $orderDetail->price;
                                }
                            }
                        @endphp
                        <td class="p-1 text-sm">
                            {{ translate('Last Month Sold')}}:
                        </td>
                        <td class="p-1">
                            {{ single_price($total) }}
                        </td>
                    </tr>
                </table>
            </div>
            <table>

            </table>
        </div>
    </div>
</div>
