@extends('user_layout.layouts.app')

@section('content')

<div id="section_best_selling" style="margin-bottom: 0px">
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container wow animate__animated animate__fadeIn" style="max-width: 1200px !important; width:100%;">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline parent_text_filter wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
                <!-- Title -->
                <div class="title_for_section">
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="top_selling_homepage">{{ translate('Top Selling') }}</span>
                    </h3>
                </div>
            </div>
            <!-- Product Section -->
            <div class="px-sm-3 wow animate__animated animate__fadeInUp" data-wow-delay=".6s" id="top_selling_filter" style="display: flex;justify-content: flex-start;padding-left: unset !important;padding-right: unset !important; flex-wrap: wrap;">
                
            </div>
        </div>
    </section> 

</div>

@endsection

@section('script')
    <script type="text/javascript">
       
    </script>
@endsection