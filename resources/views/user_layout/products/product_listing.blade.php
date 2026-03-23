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
@else
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
@endif

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
                                    <div class="p-3 mr-3">
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
                                    </div>

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
                        
                       

                        <div class="card_for_filter">
                            <div class="data_card_for_filter" style="display: flex;">
                                <div class="total_filter">
                                    <span>{{translate('Total ')}}  <span class="number_of_products">{{$total_product}}</span> {{translate(' products has been found')}}</span>
                                </div>
                                <div class="sowing_for_filter"  style="display:flex">
                                    <i class="fa fa-th" aria-hidden="true" style="font-size: 16px;"></i>
                                    <span class="text_for_filter">{{translate('Showing')}}</span>
                                    <select class="text_for_filter_select">
                                        <option>50</option>
                                        <option>100</option>
                                        <option>200</option>
                                    </select>
                                </div>
                                <div class="sort_for_filter" style="display:flex">
                                    <i class="fa-solid fa-arrow-up-short-wide" style="font-size: 16px;"></i>
                                    <span class="text_for_filter">{{translate('Sort')}}</span>
                                    <select class="text_for_filter_select" style="width: 100px !important">
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
                            <!-- Top Section -->
                            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                               
                            </div>
                            <!-- Products Section -->
                            <div class="px-sm-3 new_product_section_v2">
                                @foreach($products as $key => $product)
                                <div class="top_selling_v2">
                                    <div class="sub_top_selling_v2 position-relative has-transition border-right border-top border-bottom @if($key == 0) border-left @endif hov-animate-outline" >
                                        @if ($product->auction_product == 0)
                                            <!-- wishlisht & compare icons -->
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
                                            {{-- <img class="img_product_top_selling" src={{ static_asset($product->img_url) }} alt=""> --}}
                                            <a href="{{ $product_url }}" class="d-block h-100">
                                                <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name }}"
                                                    title="{{ $product->name }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                            {{-- @if($new_product->img_url != "")
                                               
                                            @else
                                                <img class="img_product_top_selling" src={{ static_asset('assets/img/placeholder-rect.jpg') }} alt="">
                                            @endif --}}
                                        </div>
                                        
                                        <div class="content_top_selling ">
                                            <div class="name_product_top_selling">
                                                {{$product->name}}
                                            </div>
                                            <div class="name_product_top_selling" style="margin-bottom: 6px">
                                                {{-- <span class="fa fa-star checked" style="color: orange"></span>
                                                <span class="fa fa-star checked" style="color: orange"></span>
                                                <span class="fa fa-star checked" style="color: orange"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span> --}}
                                                @php
                                                    $total = 0;
                                                    $total += $product->reviews->count();
                                                @endphp
                                                <span class="rating rating-mr-1">
                                                    {{ renderStarRating($product->rating) }}
                                                </span>
                                            </div>
                                            <div class="name_store_top_selling" style="margin-bottom: 12px;">
                                                <a href="{{route('shop.visit', $product->user?->shop?->slug) }}">
                                                    {{$product->user?->shop?->name}}
                                                </a>
                                                
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
                                            {{-- <div class="price_product_top_selling">
                                                {{home_discounted_base_price($product)}}
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                        <div class="aiz-pagination mt-4">
                            {{ $products->appends(request()->input())->onEachSide(0)->links() }}
                        </div>
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