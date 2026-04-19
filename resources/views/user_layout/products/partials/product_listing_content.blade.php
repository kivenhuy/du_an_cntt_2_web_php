{{-- Khối lọc nhanh + lưới sản phẩm + phân trang (dùng chung category & all products) --}}
@php
    $currentSort = $sort_by ?? '';
    $sortOptions = [
        'newest'     => translate('Mới nhất'),
        'price-asc'  => translate('Giá ↑'),
        'price-desc' => translate('Giá ↓'),
        'oldest'     => translate('Cũ nhất'),
    ];
@endphp
<div class="listing-topbar">
    <div class="listing-topbar-count">
        {{ translate('Tìm thấy') }}
        <strong class="listing-count-number">{{ $total_product }}</strong>
        {{ translate('sản phẩm') }}
    </div>
    <div class="listing-topbar-sort" aria-label="{{ translate('Sort') }}">
        {{-- Hidden field submitted with the form when a chip is clicked --}}
        <input type="hidden" name="sort_by" value="{{ $currentSort }}" class="listing-sort-input">
        <div class="listing-sort-chips" role="tablist">
            @foreach($sortOptions as $value => $label)
                @php $isActive = $currentSort === $value || ($currentSort === '' && $value === 'newest'); @endphp
                <button type="button"
                    class="listing-sort-chip {{ $isActive ? 'is-active' : '' }}"
                    data-sort="{{ $value }}"
                    aria-pressed="{{ $isActive ? 'true' : 'false' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>
</div>

<script>
    (function () {
        var chips = document.querySelectorAll('.listing-sort-chips .listing-sort-chip');
        if (!chips.length) return;
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                var sort = chip.getAttribute('data-sort');
                var wrap = chip.closest('.listing-topbar-sort');
                var input = wrap ? wrap.querySelector('.listing-sort-input') : null;
                if (input) input.value = sort;
                if (typeof filter === 'function') filter();
            });
        });
    })();
</script>

<div class="container" style="max-width:1200px;width: 100%" >
    <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
    </div>
    <div class="px-sm-3 new_product_section_v2">
        @foreach($products as $key => $product)
        <div class="top_selling_v2">
            <div class="sub_top_selling_v2 storefront-product-card position-relative has-transition border-right border-top border-bottom @if($key == 0) border-left @endif hov-animate-outline" >
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
                    <a href="{{ $product_url }}" class="d-block storefront-product-card-img-link" title="{{ $product->name }}">
                        <img class="lazyload mx-auto img-fit has-transition img_product_top_selling storefront-product-thumb" width="180" height="180" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name }}"
                        title="{{ $product->name }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>

                <div class="content_top_selling ">
                    <a href="{{ $product_url }}" class="d-block">
                        <div class="name_product_top_selling storefront-product-title">
                            {{$product->name}}
                        </div>
                    </a>
                    @if(($product->rating ?? 0) > 0)
                    <div class="name_product_top_selling mb-1 storefront-rating-row">
                        <span class="rating rating-mr-1">
                            {{ renderStarRating($product->rating) }}
                        </span>
                    </div>
                    @endif
                    
                    @if (home_price($product) != home_discounted_price($product))
                        <div class="d-flex align-items-baseline flex-wrap">
                            <div class="price_product_top_selling storefront-product-price">
                                {{home_discounted_base_price($product)}}
                            </div>
                            <del class="fs-14 opacity-60 ml-2 price_product_top_selling color-7">
                                {{ home_price($product) }}
                            </del>
                        </div>
                    @else
                        <div class="price_product_top_selling storefront-product-price">
                            @auth
                                {{ number_format($product->unit_price, 0, ".", ",") . " VNĐ" }}
                            @else
                                {{ guest_price_placeholder() }}
                            @endauth
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
