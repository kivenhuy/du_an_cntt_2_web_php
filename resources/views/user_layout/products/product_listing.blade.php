@extends('user_layout.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Models\Category::find($category_id)->meta_title;
        $meta_description = \App\Models\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Models\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Models\Brand::find($brand_id)->meta_description;
    @endphp
@elseif (isset($products->meta_title))
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
    @section('meta_title'){{ $meta_title }}@stop
    @section('meta_description'){{ $meta_description }}@stop
    @section('meta')
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="{{ $meta_title }}">
        <meta itemprop="description" content="{{ $meta_description }}">

        <!-- Twitter Card data -->
        <meta name="twitter:title" content="{{ $meta_title }}">
        <meta name="twitter:description" content="{{ $meta_description }}">

        <!-- Open Graph data -->
        <meta property="og:title" content="{{ $meta_title }}" />
        <meta property="og:description" content="{{ $meta_description }}" />
    @endsection
@endif





@section('content')

    <section class="mb-4 pt-4">
        <div class="container sm-px-0 pt-2" style="max-width:1200px !important;width:100%">
            <form id="search-form" action="{{ !empty($category_slug) ? route('products.category', $category_slug) : '#' }}" method="GET">
                

                @php
                    $listingActiveFilterCount = count($selected_brands ?? [])
                        + count($selected_categories ?? []);
                    if (!empty($min_price) || !empty($max_price)) $listingActiveFilterCount++;
                @endphp
                <div class="d-xl-none px-2 mb-3">
                    <button type="button" class="btn listing-filter-btn" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb">
                        <i class="fa-solid fa-sliders align-middle" aria-hidden="true"></i>
                        <span class="align-middle ml-2">{{ translate('Lọc sản phẩm') }}</span>
                        @if($listingActiveFilterCount > 0)
                            <span class="listing-filter-badge">{{ $listingActiveFilterCount }}</span>
                        @endif
                    </button>
                </div>

                <div class="row">

                    <!-- Sidebar Filters -->
                    <div class="col-xl-3">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left product-filter-sidebar-inner">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 pr-2 border-bottom py-2">
                                    <h3 class="h6 mb-0 fw-600">{{ translate('Filter products') }}</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" aria-label="Close">
                                        <span class="product-filter-drawer-closeico" aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                                    </button>
                                </div>

                                <div class="product-filter-sidebar-body">
                                <div class="bg-white border mb-0">
                                    <div class="fs-16 fw-700 p-3">
                                        <a href="#collapse_category_listing" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between text_filter" data-toggle="collapse">
                                            {{ translate('Filter panel') }}
                                        </a>
                                    </div>

                                    <div class="collapse show" id="collapse_category_listing">
                                        <div class="fs-16 fw-700 px-3 pt-0 pb-2 border-top-0">
                                            <span class="text-dark">{{ translate('Category') }}</span>
                                        </div>
                                        @include('user_layout.products.partials.filter_category_checkboxes', [
                                            'filter_categories' => $filter_categories,
                                            'selected_categories' => [],
                                            'category_id' => $category_id ?? null,
                                            'category_filter_locked' => true,
                                        ])
                                    </div>

                                    <div class="border-top">
                                        <div class="fs-16 fw-700 px-3 pt-3 pb-2">
                                            <span class="text-dark">{{ translate('Brands') }}</span>
                                        </div>
                                        @include('user_layout.products.partials.filter_brand_chips', [
                                            'filter_brands' => $filter_brands,
                                            'selected_brands' => $selected_brands ?? [],
                                        ])
                                    </div>

                                    <div class="product-filter-actions border-top p-3 bg-white">
                                        <div class="row no-gutters">
                                            <div class="col-6 pr-1">
                                                <button type="button" class="btn btn-block btn-outline-secondary rounded-pill fs-14 py-2 js-product-filter-clear">
                                                    {{ translate('Clear all') }}
                                                </button>
                                            </div>
                                            <div class="col-6 pl-1">
                                                <button type="button" class="btn btn-block btn-success rounded-pill fw-700 fs-14 py-2 js-product-filter-apply">
                                                    {{ translate('Apply') }}<span class="js-product-filter-apply-count"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nội dung lưới sản phẩm -->
                    <div class="col-xl-9" style="padding-right: unset;padding-left: unset">
                        @include('user_layout.products.partials.product_listing_content')
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        // var startSlider = document.getElementById('input-slider-range');
        // startSlider.noUiSlider.destroy();
        // noUiSlider.create(startSlider, {
        //     start: [20, 123000000],
        //     connect: true,
        //     range: {
        //         'min': [0],
        //         'max': [100]
        //     }
        // });        


        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
    @include('user_layout.products.partials.filter_deferred_apply_script', ['formId' => 'search-form'])
@endsection