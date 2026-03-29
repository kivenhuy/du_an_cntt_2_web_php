{{-- Khối lọc nhanh + lưới sản phẩm + phân trang (dùng chung category & all products) --}}
<div class="card_for_filter">
    <div class="data_card_for_filter" style="display: flex;">
        <div class="total_filter">
            <span class="total_filter-summary">{{ translate('Products found intro') }} <span class="number_of_products">{{ $total_product }}</span> {{ translate('Products found outro') }}</span>
        </div>
        <div class="sowing_for_filter"  style="display:flex">
            <i class="fa fa-th" aria-hidden="true" style="font-size: 16px;"></i>
            <span class="text_for_filter">{{ translate('Showing') }}</span>
            <select class="text_for_filter_select">
                <option>50</option>
                <option>100</option>
                <option>200</option>
            </select>
        </div>
        <div class="sort_for_filter" style="display:flex">
            <i class="fa-solid fa-arrow-up-short-wide" style="font-size: 16px;"></i>
            <span class="text_for_filter">{{ translate('Sort') }}</span>
            <select name="sort_by" class="text_for_filter_select" style="width: 100px !important" onchange="filter()">
                <option value="">{{ translate('Sort by')}}</option>
                <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
            </select>
        </div>
    </div>
</div>

<div class="container" style="max-width:1200px;width: 100%" >
    <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
    </div>
    <div class="px-sm-3 new_product_section_v2">
        @foreach($products as $key => $product)
        <div class="top_selling_v2">
            <div class="sub_top_selling_v2 position-relative has-transition border-right border-top border-bottom @if($key == 0) border-left @endif hov-animate-outline" >
                @if ($product->auction_product == 0)
                    <div class="show_hide_icon_hover">
                        <div class="icon_hover_products aiz-p-hov-icon">
                            <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToWishList({{ $product->id }})"  @else onclick="showLoginModal()" @endif
                                data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.4" viewBox="0 0 16 14.4">
                                    <g id="_51a3dbe0e593ba390ac13cba118295e4" data-name="51a3dbe0e593ba390ac13cba118295e4"
                                        transform="translate(-3.05 -4.178)">
                                        <path id="Path_32649" data-name="Path 32649"
                                            d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                            transform="translate(0 0)" fill="#919199" />
                                        <path id="Path_32650" data-name="Path 32650"
                                            d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                            transform="translate(0 0)" fill="#919199" />
                                    </g>
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToCompare({{ $product->id }})" @else onclick="showLoginModal()" @endif "
                                data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path id="_9f8e765afedd47ec9e49cea83c37dfea" data-name="9f8e765afedd47ec9e49cea83c37dfea"
                                        d="M18.037,5.547v.8a.8.8,0,0,1-.8.8H7.221a.4.4,0,0,0-.4.4V9.216a.642.642,0,0,1-1.1.454L2.456,6.4a.643.643,0,0,1,0-.909L5.723,2.227a.642.642,0,0,1,1.1.454V4.342a.4.4,0,0,0,.4.4H17.234a.8.8,0,0,1,.8.8Zm-3.685,4.86a.642.642,0,0,0-1.1.454v1.661a.4.4,0,0,1-.4.4H2.84a.8.8,0,0,0-.8.8v.8a.8.8,0,0,0,.8.8H12.854a.4.4,0,0,1,.4.4V17.4a.642.642,0,0,0,1.1.454l3.267-3.268a.643.643,0,0,0,0-.909Z"
                                        transform="translate(-2.037 -2.038)" fill="#919199" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif "
                                data-toggle="tooltip" data-title="{{ translate('Quick View') }}" data-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
                @if (home_price($product) != home_discounted_price($product))
                <div class="tag_discount">
                    <span>-{{ discount_in_percentage($product) }}%</span>
                </div>
                @endif
                <div class="top_selling_img_v2">
                    @php
                    $product_url = route('product', $product->slug);
                        if ($product->auction_product == 1) {
                            $product_url = route('auction-product', $product->slug);
                        }
                    @endphp
                    <a href="{{ $product_url }}" class="d-block h-100">
                        <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name }}"
                            title="{{ $product->name }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>

                <div class="content_top_selling ">
                    <div class="name_product_top_selling">
                        {{$product->name}}
                    </div>
                    <div class="name_product_top_selling" style="margin-bottom: 6px">
                        @php
                            $total = 0;
                            $total += $product->reviews->count();
                        @endphp
                        <span class="rating rating-mr-1">
                            {{ renderStarRating($product->rating) }}
                        </span>
                    </div>
                    <div class="name_store_top_selling" style="margin-bottom: 12px;">
                        @php
                            $__shopSlug = $product->user?->shop?->slug;
                            $__soldByName = $product->user?->shop?->name ?? $product->user?->name ?? translate('Official Store');
                        @endphp
                        @if ($__shopSlug)
                            <a href="{{ route('shop.visit', $__shopSlug) }}">{{ $__soldByName }}</a>
                        @else
                            <span>{{ $__soldByName }}</span>
                        @endif
                    </div>
                    @if (home_price($product) != home_discounted_price($product))
                        <div style="display:flex">
                            <div class="price_product_top_selling">
                                {{home_discounted_base_price($product)}}
                            </div>
                            <del class="fs-14 opacity-60 ml-2 price_product_top_selling color-7">
                                {{ home_price($product) }}
                            </del>
                        </div>
                    @else
                        <div class="price_product_top_selling">
                            {{home_discounted_base_price($product)}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
<div class="aiz-pagination mt-4">
    {{ $products->appends(request()->input())->onEachSide(0)->links() }}
</div>
