<div class=" z-3 row gutters-10">
    @php
        $photos = [];
    @endphp
    @if ($detailedProduct->photos != null)
        @php
            $photos = explode(',', $detailedProduct->photos);
        @endphp
    @endif
    <!-- Gallery Images -->
    <div class="col-12">
        <div class="aiz-carousel product-gallery arrow-inactive-transparent arrow-lg-none"
            data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true' data-arrows='true'>

            @foreach ($photos as $key => $photo)
                <div class="carousel-box img-zoom rounded-0">
                    <img class="img-fluid lazyload fixed-img fixed-img-height" width="300px" height="300px"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            @endforeach

        </div>
    </div>
    <!-- Thumbnail Images -->
    <div class="col-12 mt-3 d-none d-lg-block">
        <div class="aiz-carousel product-gallery-thumb" data-items='7' data-nav-for='.product-gallery'
            data-focus-select='true' data-arrows='true' data-vertical='false' data-auto-height='true'>

            @foreach ($photos as $key => $photo)
                <div class="carousel-box c-pointer rounded-0">
                    <img class="lazyload mw-100 size-60px mx-auto border p-1"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </div>
            @endforeach

        </div>
    </div>


</div>
<style>
    
</style>