@extends('user_layout.layouts.app')


@section('content')

    <section class="mb-4 pt-4">
        <div class="container sm-px-0 pt-2" style="max-width:1200px !important;width:100%">
            <form id="search-form" action="{{ route('products.all') }}" method="GET">
                <div class="img_category">
                    <div class="text_category">
                        <span>{{ translate('All Products') }}</span>
                    </div>
                </div>

                <div class="d-xl-none px-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-block rounded-pill py-2 product-filter-open-drawer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb">
                        <i class="fa-solid fa-sliders align-middle" aria-hidden="true"></i>
                        <span class="align-middle ml-1">{{ translate('Filter products') }}</span>
                    </button>
                </div>

                <div class="row">

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
                                        <a href="#collapse_price_all" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between text_filter" data-toggle="collapse">
                                            {{ translate('Filter panel') }}
                                        </a>
                                    </div>

                                    <!-- <div class="p-3 mr-3">
                                        <div class="row text_product_listing_sub" style="margin-bottom: 16px;margin-left:2px">
                                            @if ($min_price_choose === null && $max_price_choose === null)
                                                <span>Khoảng giá:</span>
                                                <span class="min_price" id="min_price"></span>
                                                <input type="hidden" name="min_price" value="">
                                                <input type="hidden" name="max_price" value="">
                                            @else
                                                <span>Khoảng giá:</span>
                                                <span class="min_price" id="min_price">{{ format_price(convert_price($min_price_choose)) }} - {{ format_price(convert_price($max_price_choose)) }}</span>
                                                <input type="hidden" name="min_price" value="">
                                                <input type="hidden" name="max_price" value="">
                                            @endif
                                        </div>

                                        <div class="aiz-range-slider">
                                            @php
                                                $pCond = ['published' => 1, 'approved' => 1];
                                                $publishedCount = \App\Models\Products::where($pCond)->count();
                                                $rangeMin = $publishedCount < 1 ? 0 : \App\Models\Products::where($pCond)->min('unit_price');
                                                $rangeMax = $publishedCount < 1 ? 0 : \App\Models\Products::where($pCond)->max('unit_price');
                                            @endphp
                                            @if($min_price === null && $max_price === null)
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="{{ $rangeMin }}"
                                                data-range-value-max="{{ $rangeMax }}"
                                            ></div>
                                            @else
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="{{ $min_price }}"
                                                data-range-value-max="{{ $max_price }}"
                                            ></div>
                                            @endif

                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                        @if ($min_price_choose !== null && $min_price_choose !== '')
                                                            data-range-value-low="{{ $min_price_choose }}"
                                                        @elseif($products->min('unit_price') > 0)
                                                            data-range-value-low="{{ $products->min('unit_price') }}"
                                                        @else
                                                            data-range-value-low="0"
                                                        @endif
                                                        id="input-slider-range-value-low"
                                                    ></span>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                                        @if ($max_price_choose !== null && $max_price_choose !== '')
                                                            data-range-value-high="{{ $max_price_choose }}"
                                                        @elseif($products->max('unit_price') > 0)
                                                            data-range-value-high="{{ $products->max('unit_price') }}"
                                                        @else
                                                            data-range-value-high="0"
                                                        @endif
                                                        id="input-slider-range-value-high"
                                                    ></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="collapse show" id="collapse_price_all">
                                        <div class="fs-16 fw-700 px-3 pt-0 pb-2 border-top-0">
                                            <span class="text-dark">{{ translate('Category') }}</span>
                                        </div>
                                        @include('user_layout.products.partials.filter_category_checkboxes', [
                                            'filter_categories' => $filter_categories,
                                            'selected_categories' => $selected_categories,
                                            'category_id' => null,
                                        ])
                                    </div>

                                    <div class="border-top" id="collapse_brands_all">
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
