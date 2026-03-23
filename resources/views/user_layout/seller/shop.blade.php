@extends('user_layout.layouts.app')



@section('meta_title'){{ $shop->meta_title }}@stop

@section('meta_description'){{ $shop->meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $shop->meta_title }}">
    <meta itemprop="description" content="{{ $shop->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($shop->logo) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="website">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $shop->meta_title }}">
    <meta name="twitter:description" content="{{ $shop->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($shop->meta_img) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $shop->meta_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('shop.visit', $shop->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($shop->logo) }}" />
    <meta property="og:description" content="{{ $shop->meta_description }}" />
    <meta property="og:site_name" content="{{ $shop->name }}" />
@endsection

@section('content')
   

    

    @if (!isset($type) || $type == 'top-selling' || $type == 'cupons')
        {{-- @if ($shop->top_banner) --}}
            <!-- Top Banner -->
            <section class="h-160px h-md-200px h-lg-300px  w-100">
                <img class="d-block lazyload h-100 img-fit" 
                    src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" 
                    data-src="{{ uploaded_asset($shop->top_banner) }}" alt="{{ env('APP_NAME') }} offer">
            </section>
        {{-- @endif --}}
    @endif

    <section class="@if (!isset($type) || $type == 'top-selling' || $type == 'cupons') mb-3 @endif border-top" >
        <div class="container" style="max-width: 1200px !important;width: 100%">
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <!-- Seller Info -->
            <div class="info_seller">
                <div class="data_img_seller">
                    <a href="{{ route('shop.visit', $shop->slug) }}" class="overflow-hidden size-64px rounded-content">
                        <img class="img_logo_seller lazyload h-64px  mx-auto"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($shop->logo) }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>
                <div class="name_seller">
                    <span>{{$shop->name}}</span>
                </div>
                
            </div>

            <div class="info_seller_mobile">
                <div class="data_img_seller">
                    <a href="{{ route('shop.visit', $shop->slug) }}" class="overflow-hidden size-64px rounded-content" style="border: 1px solid #e5e5e5;
                        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                        <img class="img_logo_seller lazyload h-64px  mx-auto"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($shop->logo) }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>
                <div class="name_seller">
                    <span>{{$shop->name}}</span>
                </div>
                
            </div>
            <div class="relate_info_seller">
                <div class="description_seller" style="width: 70%">
                    <div class="text_head">
                        <span>{{ translate('Description') }}</span>
                    </div>
                    <div class="description_shop">
                        {!! $shop->meta_description !!}
                    </div>
                </div>
                <div class="count_info_seller">
                    <div class="text_head">
                        <span>{{ translate('Info') }}</span>
                    </div>
                    
                    

                    <div class="text_head" style="margin-top: 3rem;">
                        <span>{{ translate('Social Link') }}</span>
                    </div>
                    <div class="social_link">
                        @if(isset($shop->facebook))
                            <a href="{{$shop->facebook}}"  target="_blank">
                                <div class="img_social_link">
                                    {{-- <img width="100%" src="{{static_asset('uploads/all/Uu6T6wkxcJ1SivxZF3cSCRvcDUYfseE22V7xkps1.png')}}" alt=""> --}}
                                    <img width="100%" src="{{static_asset('uploads/all/tOabkBrmWeavynYagHi2mb0nL7GuUWxq7nBzlylC.png')}}" alt="">
                                </div>
                            </a>
                        @endif
                        @if(isset($shop->youtube))
                            <a href="{{$shop->youtube}}"  target="_blank">
                                <div class="img_social_link">
                                    {{-- <img width="100%" src="{{static_asset('uploads/all/vcqu0cawJJk9GlsMBVgftmWp0sxXYQbK3iYmdUPU.png')}}" alt=""> --}}
                                    <img width="100%" src="{{static_asset('uploads/all/LN2e5NBi71LGObw6RlqwKaXFM47n3Qsn4wWaGRx8.png')}}" alt="">
                                </div>
                            </a>    
                        @endif
                        @if(isset($shop->google))
                            <a href="{{$shop->google}}"  target="_blank">
                                <div class="img_social_link">
                                    {{-- <img width="100%" src="{{static_asset('uploads/all/vcqu0cawJJk9GlsMBVgftmWp0sxXYQbK3iYmdUPU.png')}}" alt=""> --}}
                                    <img width="100%" src="{{static_asset('uploads/all/vnUS0oFHalHEH1y27zan3D58p7IoQSEdPpIkQE2N.png')}}" alt="">
                                </div>
                            </a>    
                        @endif
                    </div>
                </div>
            </div>
            
            
            
        </div>
    </section>
        
    
        <!-- Banner Slider -->
        <section class="mt-3 mb-3">
            <div class="container" style="max-width:1200px !important">
                <div class="aiz-carousel mobile-img-auto-height" data-arrows="true" data-dots="false" data-autoplay="true">
                    @if ($shop->sliders != null)
                        @foreach (explode(',',$shop->sliders) as $key => $slide)
                            <div class="carousel-box w-100 h-140px h-md-300px" style="height: 360px;">
                                <img style="display: block" width="100%" height="100%" class="d-block lazyload " src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($slide) }}" alt="{{ $key }} offer">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        
       

        <section class="mt-90">
            
            <div class="container" style="max-width:1200px">
                <div class="text_head_seller_info">
                    <h3 class="fs-16 fs-md-20 fw-700 mb-3 mb-sm-0">
                        <span class="pb-3" style="
                        font-family: 'Quicksand',sans-serif !important;
                        font-size: 32px !important;
                        font-weight: 700 !important;
                        line-height: 40px !important;
                        letter-spacing: -0.0004em;
                        color:#2E7F25;
                        ">{{ translate('Products') }}</span>
                    </h3>
                </div>
                <form class="" id="search-form" action="" method="GET">
                    <div class="row gutters-16 justify-content-center">
                        <!-- Sidebar -->
                        <div class="col-xl-3 col-md-6 col-sm-8">

                            <!-- Sidebar Filters -->
                            <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                                <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                                <div class="collapse-sidebar c-scrollbar-light text-left">
                                    <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                        <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                        <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                            <i class="las la-times la-2x"></i>
                                        </button>
                                    </div>

                                    <!-- Price range -->
                                    <div class="bg-white border mb-3">
                                        <div class="fs-16 fw-700 p-3">
                                            {{ translate('Price range')}}
                                        </div>
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
                                                <div
                                                    id="input-slider-range"
                                                    data-range-value-min="@if(\App\Models\Products::where(['user_id' => $shop->user->id, 'published' => 1, 'approved' => 1])->count() < 1) 0 @else {{ \App\Models\Products::where(['user_id' => $shop->user->id, 'published' => 1, 'approved' => 1])->min('unit_price') }} @endif"
                                                    data-range-value-max="@if(\App\Models\Products::where(['user_id' => $shop->user->id, 'published' => 1, 'approved' => 1])->count() < 1) 0 @else {{ \App\Models\Products::where(['user_id' => $shop->user->id, 'published' => 1, 'approved' => 1])->max('unit_price') }} @endif"
                                                ></div>

                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                            @if ($min_price != null)
                                                                data-range-value-low="{{ $min_price }}"
                                                            @elseif($products->min('unit_price') > 0)
                                                                data-range-value-low="{{ $products_all->min('unit_price') }}"
                                                            @else
                                                                data-range-value-low="0"
                                                            @endif
                                                            id="input-slider-range-value-low"
                                                        ></span>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                                            @if ($max_price != null)
                                                                data-range-value-high="{{ $max_price }}"
                                                            @elseif($products->max('unit_price') > 0)
                                                                data-range-value-high="{{ $products_all->max('unit_price') }}"
                                                            @else
                                                                data-range-value-high="0"
                                                            @endif
                                                            id="input-slider-range-value-high"
                                                        ></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>

                                    <!-- Categories -->
                                    <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                        <div class="fs-16 fw-700 p-3">
                                            <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                {{ translate('Categories')}}
                                            </a>
                                        </div>
                                        <div class="collapse show px-3" id="collapse_1">
                                            @php
                                                $category_ids = \App\Models\Products::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->pluck('category_id')->toArray();
                                            @endphp
                                            @foreach (\App\Models\Category::whereIn('id', $category_ids)->get() as $category)
                                                <label class="aiz-checkbox mb-3">
                                                    <input
                                                        type="checkbox"
                                                        name="selected_categories[]"
                                                        value="{{ $category->id }}" @if (in_array($category->id, $selected_categories)) checked @endif
                                                        onchange="filter()"
                                                    >
                                                    <span class="aiz-square-check"></span>
                                                    <span class="fs-14 fw-400 text-dark">{{ $category->name }}</span>
                                                </label>
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>

                                    

                                    <!-- Ratings -->
                                    <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                        <div class="fs-16 fw-700 p-3">
                                            <a href="#collapse_2" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                {{ translate('Ratings')}}
                                            </a>
                                        </div>
                                        <div class="collapse show px-3" id="collapse_2">
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="5" @if ($rating==5) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="rating rating-mr-1">{{ renderStarRating(5) }}</span>
                                            </label>
                                            <br>
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="4" @if ($rating==4) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="rating rating-mr-1">{{ renderStarRating(4) }}</span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                            </label>
                                            <br>
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="3" @if ($rating==3) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="rating rating-mr-1">{{ renderStarRating(3) }}</span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                            </label>
                                            <br>
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="2" @if ($rating==2) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="rating rating-mr-1">{{ renderStarRating(2) }}</span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                            </label>
                                            <br>
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="rating"
                                                    value="1" @if ($rating==1) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="rating rating-mr-1">{{ renderStarRating(1) }}</span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('And Up')}}</span>
                                            </label>
                                            <br>
                                        </div>
                                    </div>

                                    

                                </div>
                            </div>
                        </div>
                        
                        <!-- Contents -->
                        <div class="col-xl-9">
                            <!-- Top Filters -->
                            <div class="text-left mb-2">
                                <div class="row gutters-5 flex-wrap">
                                    <div class="col-lg col-10">
                                        {{-- <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                                            {{ translate('All Products') }}
                                        </h1> --}}
                                    </div>
                                    <div class="col-2 col-lg-auto d-xl-none mb-lg-3 text-right">
                                        <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                            <i class="la la-filter la-2x"></i>
                                        </button>
                                    </div>
                                    <div class="col-6 col-lg-auto mb-3 w-lg-200px">
                                        <select class="form-control form-control-sm aiz-selectpicker rounded-0" name="sort_by" onchange="filter()">
                                            <option value="">{{ translate('Sort by')}}</option>
                                            <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                            <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                            <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                            <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Products -->
                            <div class="px-sm-3 new_product_section_v2">
                                {{-- <div class="row gutters-16 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2 border-top border-left"> --}}
                                    @foreach ($products as $key => $product)
                                        {{-- <div class="col border-right border-bottom has-transition hov-shadow-out z-1"> --}}
                                            @include('user_layout.partials.product_box_1',['product' => $product])
                                        {{-- </div> --}}
                                    @endforeach
                                {{-- </div> --}}
                            </div>
                            <div class="aiz-pagination mt-4">
                                {{ $products->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        

    <div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 800px !important">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="carouselExample" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php $count_data_img_certificates=0 ?>
                    @foreach ($img_certificates as $data_img_certificates)
                        @if( $count_data_img_certificates == 0)
                            <li data-target="#carouselExample" data-slide-to="{{$count_data_img_certificates}}" class="active"></li>
                        @else
                            <li data-target="#carouselExample" data-slide-to="{{$count_data_img_certificates}}"></li>
                        @endif
                        <?php $count_data_img_certificates +=1 ?>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    <?php $count_data_img_certificates=0 ?>
                    @foreach ($img_certificates as $data_img_certificates)
                        <div  @if( $count_data_img_certificates == 0) class="carousel-item active" @else class="carousel-item"  @endif>
                            <img class="d-block img_modal_showing" src="{{uploaded_asset($data_img_certificates)}}">
                        </div>
                        <?php $count_data_img_certificates +=1 ?>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                  <i class="fa fa-angle-left" aria-hidden="true" style="font-size: 28px;color:#333333"></i>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                  <i class="fa fa-angle-right" aria-hidden="true" style="font-size: 28px;color:#333333"></i>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade exampleModal" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 800px !important">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="max-height: 60vh !important">
              <div id="product_factory" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php $count_data_img_product_factories=0 ?>
                    @foreach ($img_product_factories as $data_img_certificates)
                        @if( $count_data_img_product_factories == 0)
                            <li data-target="#product_factory" data-slide-to="{{$count_data_img_product_factories}}" class="active"></li>
                        @else
                            <li data-target="#product_factory" data-slide-to="{{$count_data_img_product_factories}}"></li>
                        @endif
                        <?php $count_data_img_product_factories +=1 ?>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    <?php $count_data_img_product_factories=0 ?>
                    @foreach ($img_product_factories as $data_img_certificates)
                        <div  @if( $count_data_img_product_factories == 0) class="carousel-item active" @else class="carousel-item"  @endif>
                            <img class="d-block img_modal_showing" src="{{uploaded_asset($data_img_certificates)}}">
                        </div>
                        <?php $count_data_img_product_factories +=1 ?>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#product_factory" role="button" data-slide="prev">
                    <i class="fa fa-angle-left" aria-hidden="true" style="font-size: 28px;color:#333333"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#product_factory" role="button" data-slide="next">
                    <i class="fa fa-angle-right" aria-hidden="true" style="font-size: 28px;color:#333333"></i>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

@endsection

<style>
    
    .carousel-item-next, .carousel-item-prev, .carousel-item.active {
        display: flex !important;
        justify-content: center;
    }
    .aiz-carousel.sm-gutters-16 .carousel-box 
    {
        /* width: 70% !important; */
    }
    .img_modal_showing
    {
        max-width: 800px !important;
        max-height: 60vh !important;
    }
    /* .slick-slide {
        width: 25% !important;
    } */
    $bootstrap-sm: 576px;
    $bootstrap-md: 768px;
    $bootstrap-lg: 992px;
    $bootstrap-xl: 1200px;


    @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1 !important;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    }

    .close:hover,
    .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (min-width: 1200px){
    .modal-content {
        width: 100%;
    }
    }
</style>

@section('script')
    <script type="text/javascript">

        $(document).ready(function() {
            // alert($("input[name=shop_id]").val());
            $('#shop_id').val($("input[name=shop_id]").val());
        });

        $(document).keydown(function(e) {
            if (e.keyCode === 37) {
            // Previous
                $(".carousel-control-prev").click();
                return false;
            }
            if (e.keyCode === 39) {
                // Next
                $(".carousel-control-next").click();
                return false;
            }
        });

        function filter(){
            $('#search-form').submit();
        }
        
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
        var modal = document.getElementById("myModal");
        function open_modal_picture(data)
        {
            
            var modalImg = document.getElementById("img01");
            src = data.src;
            modal.style.display = "block";
            modalImg.src = this.src;
            // alert(src);
        }
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
        modal.style.display = "none";
        }

        $(document).keydown(function(event) { 
            if (event.keyCode == 27) { 
                modal.style.display = "none";
            }
        });

    </script>
@endsection