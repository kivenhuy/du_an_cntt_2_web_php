@extends('user_layout.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    @php
        $availability = "out of stock";
        $qty = 0;
        if($detailedProduct->variant_product) {
            foreach ($detailedProduct->stocks as $key => $stock) {
                $qty += $stock->qty;
            }
        }
        else {
            $qty = optional($detailedProduct->product_stock->first())->qty;
        }
        if($qty > 0){
            $availability = "in stock";
        }
    @endphp
    
@endsection

@section('content')
    <section class="mb-4 pt-3" style="margin-top:54px">
        <div class="container" style="max-width: 1200px !important;width: 100%">

            <!-- Breadcrumb -->
                        <ul class="breadcrumb bg-transparent py-0 px-1">
                            <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                                <a class="text-reset" href="{{ route('homepage') }}">{{ translate('Home')}}</a>
                            </li>
                            @if(!isset($detailedProduct->id))
                                <li class="breadcrumb-item fw-700  text-dark">
                                    "{{ translate('All Categories')}}"
                                </li>
                            @else
                                <li class="breadcrumb-item opacity-50 hov-opacity-100">

                                    <a href=""
                                        class="text-reset">{{ $categories_data->name }}
                                    </a>
                                    {{-- <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a> --}}
                                </li>
                            @endif
                            @if(isset($detailedProduct->id))
                                <li class="text-dark fw-600 breadcrumb-item">
                                    "{{ $detailedProduct->name }}"
                                </li>
                            @endif
                        </ul>
            <div class="bg-white py-3">
                <div class="row">
                    <!-- Product Image Gallery -->
                    <div class="col-xl-5 col-lg-6 mb-4">
                        @include('user_layout.products.product_details.image_gallery')
                    </div>

                    <!-- Product Details -->
                    <div class="col-xl-7 col-lg-6">
                        @include('user_layout.products.product_details.details')
                    </div>
                </div>
            </div>

           <div class="description_product product-info">
                <div class="tab-style3">
                    <ul class="nav nav-tabs text-uppercase" id="custom-content-below-tab"  role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-product-description-tab" data-toggle="pill" href="#product_description" role="tab" aria-controls="custom-content-below-product-description" aria-selected="true"><span class="text_details_product_desc font-size-mobile">{{ translate('Description') }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-product-query-tab" data-toggle="pill" href="#product_query" role="tab" aria-controls="custom-content-below-product-query" aria-selected="false"><span class="text_details_product_desc font-size-mobile">{{ translate('Product Queries') }}</span></a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-product-reviews-tab" data-toggle="pill" href="#product_riviews" role="tab" aria-controls="custom-content-below-product-reviews" aria-selected="false"> <span class="text_details_product_desc font-size-mobile">{{ translate('Reviews') }}</span></a>
                        </li>

                        @if(!empty($detailedProduct->pdf))
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-product-document-tab" data-toggle="pill" href="#product_documents" role="tab" aria-controls="custom-content-below-product_documents" aria-selected="false"> <span class="text_details_product_desc font-size-mobile">{{ translate('Documents') }}</span></a>
                            </li>
                        @endif
                        @if(($detailedProduct->auction_product == 1 ) && $product_traceability == 1)
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-product-traceability-tab" data-toggle="pill" href="#product_traceabilitys" role="tab" aria-controls="custom-content-below-product_traceabilitys" aria-selected="false"> <span class="text_details_product_desc font-size-mobile">{{ translate('Product Traceability') }}</span></a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content shop_info_tab entry-main-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="product_description" role="tabpanel">    
                                <div class=""> {!! $detailedProduct->description !!}</div>  
                        </div>
                        <div class="tab-pane fade" id="product_query" role="tabpanel">
                            <!-- Product Query -->
                            @include('user_layout.products.product_details.product_queries')
                        </div>
                        
                        <div class="tab-pane fade" id="product_riviews" role="tabpanel" aria-labelledby="Reviews-tab">
                            @include('user_layout.products.product_details.reviews')
                        </div>
                            
                       
                    </div>
                </div>
             </div>
                        
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            @if ($detailedProduct->auction_product)
                {{-- <!-- Reviews & Ratings -->
                @include('user_layout.products.product_details.review_section')
                
                <!-- Description, Video, Downloads -->
                @include('user_layout.products.product_details.description')
                
                <!-- Product Query -->
                @include('user_layout.products.product_details.product_queries') --}}
            @else
                <div class="row gutters-16">
                    <!-- Left side -->
                    {{-- <div class="col-lg-3">
                        <!-- Seller Info -->
                        @include('user_layout.products.product_details.seller_info')

                        <!-- Top Selling Products -->
                       <div class="d-none d-lg-block">
                            @include('user_layout.products.product_details.top_selling_products')
                       </div>
                    </div> --}}

                    <!-- Right side -->
                    <div class="col-lg-12">
                        
                        <!-- Reviews & Ratings -->
                        {{-- @include('user_layout.products.product_details.review_section') --}}

                        <!-- Description, Video, Downloads -->
                        {{-- @include('user_layout.products.product_details.description') --}}
                        
                        <!-- Related products -->
                        @include('user_layout.products.product_details.related_product')

                        <!-- Product Query -->
                        {{-- @include('user_layout.products.product_details.product_queries') --}}
                        
                        <!-- Top Selling Products -->
                        <div class="d-none">
                             @include('user_layout.products.product_details.top_selling_products')
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('modal')
    <!-- Image Modal -->
    <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="size-300px size-lg-450px">
                        <img class="img-fit h-100 lazyload"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src=""
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>
@endsection
<style>
.nav-tabs .nav-item {
    margin-left: 8px;
}
</style>
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            // getVariantPrice();
        });

        

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        // Pagination using ajax
        $(window).on('hashchange', function() {
            if(window.history.pushState) {
                window.history.pushState('', '/', window.location.pathname);
            } else {
                window.location.hash = '';
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.product-queries-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'query', 'queries-area');
                e.preventDefault();
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.product-reviews-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'review', 'reviews-area');
                e.preventDefault();
            });
        });

        function getPaginateData(page, type, section) {
            $.ajax({
                url: '?page=' + page,
                dataType: 'json',
                data: {type: type},
            }).done(function(data) {
                $('.'+section).html(data);
                location.hash = page;
            }).fail(function() {
                alert('Something went worng! Data could not be loaded.');
            });
        }
        // Pagination end

        function showImage(photo) {
            $('#image_modal img').attr('src', photo);
            $('#image_modal img').attr('data-src', photo);
            $('#image_modal').modal('show');
        }

        function product_review(product_id) {
            @if (isCustomer())
                @if ($review_status == 1)
                    $.post('{{ route('product_review_modal') }}', {
                        _token: '{{ @csrf_token() }}',
                        product_id: product_id
                    }, function(data) {
                        $('#product-review-modal-content').html(data);
                        $('#product-review-modal').modal('show', {
                            backdrop: 'static'
                        });
                        AIZ.extra.inputRating();
                    });
                @else
                    AIZ.plugins.notify('warning', '{{ translate("Sorry, You need to buy this product to give review.") }}');
                @endif
            @elseif (Auth::check() && !isCustomer())
                AIZ.plugins.notify('warning', '{{ translate("Sorry, Only customers can give review.") }}');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        function show_message_download ($data){
            AIZ.plugins.notify('success', '{{ translate("Downloaded Successfully.") }}');
        }

        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("showing");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                content.style.display = "none";
                } else {
                content.style.display = "block";
                }
            });
        }


    </script>
@endsection
