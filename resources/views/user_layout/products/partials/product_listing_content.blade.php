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
                        <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name }}"
                        title="{{ $product->name }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>

                <div class="content_top_selling ">
                    <a href="{{ $product_url }}" class="d-block">
                        <div class="name_product_top_selling">
                            {{$product->name}}
                        </div>
                    </a>
                    <div class="name_product_top_selling" style="margin-bottom: 6px">
                        @php
                            $total = 0;
                            $total += $product->reviews->count();
                        @endphp
                        <span class="rating rating-mr-1">
                            {{ renderStarRating($product->rating) }}
                        </span>
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
                            {{number_format($product->unit_price, 0, ".", ",")." VNĐ"  }}
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
