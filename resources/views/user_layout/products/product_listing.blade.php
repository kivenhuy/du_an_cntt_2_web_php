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
            <form class="" id="search-form" action="" method="GET">
                <div class="img_category">
                    <div class="text_category">
                        <span>
                            @if(isset($category_id))
                            {{ \App\Models\Category::find($category_id)->name }}
                        @elseif(isset($query))
                            {{ translate('Search result for ') }}"{{ $query }}"
                        @else
                            {{ translate('All Products') }}
                        @endif</span>
                    </div>
                </div>

                <div class="row">

                    <!-- Sidebar Filters -->
                    <div class="col-xl-3">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>

                                <!-- Categories -->
                                <div class="bg-white border mb-3">
                                    <div class="fs-16 fw-700 p-3">
                                        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between text_filter" data-toggle="collapse">
                                            {{ translate('Fiter')}}
                                        </a>
                                    </div>

                                    {{-- Range Price --}}
                                    <!-- <div class="p-3 mr-3">
                                        <div class="row text_product_listing_sub" style="margin-bottom: 16px;margin-left:2px">
                                            @if (!isset($min_price_choose) && !isset($max_price_choose))
                                                <span>Khoảng giá:</span>
                                                <span class="min_price" id="min_price"></span>
                                                <input type="hidden" name="min_price" value="">
                                                <input type="hidden" name="max_price" value="">
                                                {{-- <span id="max_price"></span> --}}
                                            @else
                                                <span>Khoảng giá:</span>
                                                <span class="min_price" id="min_price">{{format_price(convert_price($min_price_choose))}} - {{format_price(convert_price($max_price_choose))}}</span>
                                                <input type="hidden" name="min_price" value="">
                                                <input type="hidden" name="max_price" value="">
                                            @endif

                                        </div>
                                        
                                        <div class="aiz-range-slider">
                                            @if($min_price == null && $max_price == null)
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="@if(\App\Models\Product::where('published', 1)->count() < 1) 0 @else {{ \App\Models\Product::where('published', 1)->min('unit_price') }} @endif"
                                                data-range-value-max="@if(\App\Models\Product::where('published', 1)->count() < 1) 0 @else {{ \App\Models\Product::where('published', 1)->max('unit_price') }} @endif"
                                            ></div>
                                            @else
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="{{$min_price}}"
                                                data-range-value-max="{{$max_price}}"
                                            ></div>
                                            @endif

                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                        @if (isset($min_price_choose))
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
                                                        @if (isset($max_price_choose))
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

                                    {{-- sub categories --}}
                                    <div class="collapse show" id="collapse_1">
                                        <ul class="p-3 mb-0 list-unstyled">
                                            @if (!isset($category_id))
                                                @foreach (\App\Models\Category::where('level', 0)->get() as $category)
                                                    <li class="mb-3 text-dark">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('products.category', $category->slug) }}">{{ $category->name }}</a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="mb-3">
                                                   <span style="font-family: Roboto,sans-serif !important;
                                                   font-size: 16px !important;
                                                   font-weight: 400 !important;
                                                   line-height: 24px;
                                                   letter-spacing: 0em;
                                                   text-align: left;
                                                    color: #B6B6B6;
                                                   ">{{ translate('Category')}}</span>
                                                </li>
                                                @if (\App\Models\Category::find($category_id)->parent_id != 0)
                                                    <li class="mb-3">
                                                        <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('products.category', \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->slug) }}">
                                                            
                                                            {{ \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="mb-3" data-toggle="collapse">
                                                    <input type="checkbox">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary text_product_listing" href="{{ route('products.category', \App\Models\Category::find($category_id)->slug) }}">
                                                        {{ \App\Models\Category::find($category_id)->name }}
                                                    </a>
                                                </li>
                                               
                                            @endif
                                        </ul>
                                    </div>

                                    {{-- button filter --}}
                                    <div class="button_filter" style="margin-bottom: 1rem;display:flex;justify-content: space-evenly">
                                        <button  onclick="handleClick(this);" style="width:40%" type="button" class="btn btn-success btn-block fw-700 fs-14 rounded-4 EdSubmitFinal">Filter</button>
                                    </div>
                                </div>

                                
                                
                               

                                
                        
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contents -->
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
            // alert(arg[1])
            filter();
        }

        // function handleClick(myRadio) {
        //     alert($('input[name=min_price]').val());
        // }
    </script>
@endsection