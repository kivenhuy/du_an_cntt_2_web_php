@extends('user_layout.layouts.app')

@section('content')
<section class="mb-5">

    {{-- Banner --}}
    @if($brand->banner)
        <div class="brand-banner-wrap mb-4">
            <img src="{{ uploaded_asset($brand->banner) }}" alt="{{ $brand->name }} banner"
                 class="w-100 brand-banner-img">
        </div>
    @else
        <div class="brand-banner-placeholder mb-4"></div>
    @endif

    <div class="container" style="max-width:1200px">

        {{-- Brand identity row --}}
        <div class="d-flex align-items-center mb-4 brand-identity-row">
            <div class="brand-logo-wrap mr-4 flex-shrink-0">
                @if($brand->logo)
                    <img src="{{ uploaded_asset($brand->logo) }}" alt="{{ $brand->name }}"
                         class="brand-detail-logo">
                @else
                    <div class="brand-detail-logo-placeholder d-flex align-items-center justify-content-center">
                        <span style="font-size:2rem;font-weight:700;color:#5a7bd5">
                            {{ mb_strtoupper(mb_substr($brand->name, 0, 2)) }}
                        </span>
                    </div>
                @endif
            </div>
            <div>
                <h1 class="h3 mb-1 fw-700">{{ $brand->name }}</h1>
                @if($brand->description)
                    <p class="mb-0 text-muted" style="max-width:600px;font-size:.95rem;">
                        {{ $brand->description }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Thương hiệu</a></li>
                <li class="breadcrumb-item active">{{ $brand->name }}</li>
            </ol>
        </nav>

        {{-- 2-column layout: sidebar trái + sản phẩm phải --}}
        <form id="brand-filter-form" method="GET" action="{{ route('brands.show', $brand->slug) }}">
            <div class="row">

                {{-- ── Sidebar filter (trái) ── --}}
                <div class="col-xl-3">
                    <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                        <div class="overlay overlay-fixed dark c-pointer"
                             data-toggle="class-toggle"
                             data-target=".aiz-filter-sidebar"
                             data-same=".filter-sidebar-thumb"></div>

                        <div class="collapse-sidebar c-scrollbar-light text-left">
                            {{-- Mobile header --}}
                            <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb"
                                        data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                    <i class="las la-times la-2x"></i>
                                </button>
                            </div>

                            <div class="bg-white border mb-3">
                                <div class="fs-16 fw-700 p-3">
                                    <a href="#collapse_brand_cats"
                                       class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between text_filter"
                                       data-toggle="collapse">
                                        {{ translate('Fiter') }}
                                    </a>
                                </div>

                                <div class="collapse show" id="collapse_brand_cats">
                                    <div class="fs-16 fw-700 px-3 pt-0 pb-2 border-top-0">
                                        <span class="text-dark">{{ translate('Categories') }}</span>
                                    </div>
                                    <ul class="p-3 mb-0 list-unstyled">
                                        @forelse($filter_categories as $category)
                                            <li class="mb-2">
                                                <label class="aiz-checkbox mb-0 d-flex align-items-start">
                                                    <input type="checkbox"
                                                           name="selected_categories[]"
                                                           value="{{ $category->id }}"
                                                           @if(in_array($category->id, $selected_categories, true)) checked @endif>
                                                    <span class="aiz-square-check"></span>
                                                    <span class="fs-14 fw-400 text-dark">{{ $category->name }}</span>
                                                </label>
                                            </li>
                                        @empty
                                            <li class="text-muted fs-14">{{ translate('No categories') }}</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div class="button_filter" style="margin-bottom:1rem;display:flex;justify-content:space-evenly">
                                    <button type="submit" style="width:40%"
                                            class="btn btn-success btn-block fw-700 fs-14 rounded-4">
                                        {{ translate('Filter') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Sản phẩm (phải) ── --}}
                <div class="col-xl-9" style="padding-right:unset;padding-left:unset">

                    {{-- Toolbar --}}
                    <div class="card_for_filter mb-3">
                        <div class="data_card_for_filter" style="display:flex">
                            <div class="total_filter">
                                <span class="total_filter-summary">
                                    Tìm thấy <span class="number_of_products">{{ $products->total() }}</span> sản phẩm
                                </span>
                            </div>
                            <div class="sowing_for_filter" style="display:flex">
                                <i class="fa fa-th" aria-hidden="true" style="font-size:16px"></i>
                                <span class="text_for_filter">Hiển thị</span>
                                <select name="per_page" class="text_for_filter_select" onchange="this.form.submit()">
                                    <option value="16" @if($perPage==16) selected @endif>16</option>
                                    <option value="32" @if($perPage==32) selected @endif>32</option>
                                    <option value="50" @if($perPage==50) selected @endif>50</option>
                                </select>
                            </div>
                            <div class="sort_for_filter" style="display:flex">
                                <i class="fa-solid fa-arrow-up-short-wide" style="font-size:16px"></i>
                                <span class="text_for_filter">Sắp xếp</span>
                                <select name="sort_by" class="text_for_filter_select" style="width:130px!important" onchange="this.form.submit()">
                                    <option value="newest"     @if($sort_by=='newest')     selected @endif>Mới nhất</option>
                                    <option value="oldest"     @if($sort_by=='oldest')     selected @endif>Cũ nhất</option>
                                    <option value="price-asc"  @if($sort_by=='price-asc')  selected @endif>Giá thấp → cao</option>
                                    <option value="price-desc" @if($sort_by=='price-desc') selected @endif>Giá cao → thấp</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Product grid --}}
                    @if($products->count())
                        <div class="px-sm-3 new_product_section_v2">
                            @foreach($products as $key => $product)
                                <div class="top_selling_v2">
                                    <div class="sub_top_selling_v2 position-relative has-transition border-right border-top border-bottom @if($key==0) border-left @endif hov-animate-outline">
                                        @if(home_price($product) != home_discounted_price($product))
                                            <div class="tag_discount"><span>-{{ discount_in_percentage($product) }}%</span></div>
                                        @endif
                                        <div class="top_selling_img_v2">
                                            <img class="lazyload mx-auto img-fit has-transition img_product_top_selling"
                                                 width="180" height="180"
                                                 src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                 data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                 alt="{{ $product->name }}"
                                                 onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                        <div class="content_top_selling">
                                            <div class="name_product_top_selling">
                                                <a href="{{ route('product', $product->slug) }}"
                                                   class="text-dark hov-text-primary" style="text-decoration:none">
                                                    {{ $product->name }}
                                                </a>
                                            </div>
                                            <div class="name_product_top_selling" style="margin-bottom:6px">
                                                <span class="rating rating-mr-1">{{ renderStarRating($product->rating) }}</span>
                                            </div>
                                            <div class="name_store_top_selling" style="margin-bottom:12px">
                                                @php
                                                    $__shopSlug  = $product->user?->shop?->slug;
                                                    $__soldByName = $product->user?->shop?->name ?? $product->user?->name ?? translate('Official Store');
                                                @endphp
                                                @if($__shopSlug)
                                                    <a href="{{ route('shop.visit', $__shopSlug) }}">{{ $__soldByName }}</a>
                                                @else
                                                    <span>{{ $__soldByName }}</span>
                                                @endif
                                            </div>
                                            @if(home_price($product) != home_discounted_price($product))
                                                <div style="display:flex">
                                                    <div class="price_product_top_selling">{{ home_discounted_base_price($product) }}</div>
                                                    <del class="opacity-60 ml-2 price_product_top_selling color-7">{{ home_price($product) }}</del>
                                                </div>
                                            @else
                                                <div class="price_product_top_selling">
                                                    {{ number_format($product->unit_price, 0, '.', ',') }} VNĐ
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="aiz-pagination mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fa fa-box-open fa-3x mb-3 d-block"></i>
                            <p>Không tìm thấy sản phẩm phù hợp.</p>
                            <a href="{{ route('brands.show', $brand->slug) }}" class="btn btn-outline-secondary mt-2">Xoá bộ lọc</a>
                        </div>
                    @endif

                </div>{{-- /col-xl-9 --}}
            </div>{{-- /row --}}
        </form>

    </div>
</section>
@endsection

@section('style')
<style>
/* ── Banner & logo ── */
.brand-banner-wrap { max-height: 240px; overflow: hidden; }
.brand-banner-img  { width: 100%; height: 240px; object-fit: cover; object-position: center; }
.brand-banner-placeholder {
    height: 160px;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
}
.brand-detail-logo {
    width: 100px; height: 100px;
    border: 1px solid #eaeaea;
    border-radius: 12px;
    background: #fff;
    object-fit: contain;
    padding: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}
.brand-detail-logo-placeholder {
    width: 100px; height: 100px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f0f4ff, #dce8ff);
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}

/* ── Responsive ── */
@media (max-width: 575px) {
    .brand-identity-row { flex-direction: column; align-items: flex-start; }
    .brand-logo-wrap { margin-bottom: 12px; }
}
</style>
@endsection
