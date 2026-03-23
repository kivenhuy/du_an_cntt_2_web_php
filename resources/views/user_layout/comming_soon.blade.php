@extends('user_layout.layouts.app')

@section('content')
    <div class="position-relative">
        <div class="position-absolute" id="particles-js"></div>
        <div class="position-relative container">
            <div class="comming_soon">
                <div class="text_comming_soon">
                   <span >{{ translate('Coming Soon')}}</span> 
                </div>
                <div class="sub_text_comming_soon">
                    <span >{{ translate('Content for this page is under construction and will be launched very soon.')}}</span> 
                 </div>
                 <div>
                    {{-- <img src={{static_asset('uploads/all/Vh6J4dIw0z0dVyldG7Jn3GNdjxbxT8xV3pejnhY1.png') }} alt="">  --}}
                    <img src={{ static_asset('assets/img/2d8OdftLDlLcbdWmTv7A3az1ED65vyIrSKTEdWPV.png')}} alt=""> 
                   
                 </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        AIZ.plugins.particles();
    </script>
@endsection
