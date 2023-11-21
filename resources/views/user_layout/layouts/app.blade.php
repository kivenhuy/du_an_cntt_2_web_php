<!DOCTYPE html>

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

   

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">

    @yield('meta')

    
   <!-- Favicon -->

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   

   <!-- CSS Files -->
   <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
   <link rel="stylesheet" href="{{ static_asset('assets/css/custom-style.css?v=') }}{{ now()->timestamp }}">
   <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


   @yield('style')
   <script>
       var AIZ = AIZ || {};
       AIZ.local = {
           nothing_selected: '{!! translate('Nothing selected', null, true) !!}',
           nothing_found: '{!! translate('Nothing found', null, true) !!}',
           choose_file: '{{ translate('Choose file') }}',
           file_selected: '{{ translate('File selected') }}',
           files_selected: '{{ translate('Files selected') }}',
           add_more_files: '{{ translate('Add more files') }}',
           adding_more_files: '{{ translate('Adding more files') }}',
           drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
           browse: '{{ translate('Browse') }}',
           upload_complete: '{{ translate('Upload complete') }}',
           upload_paused: '{{ translate('Upload paused') }}',
           resume_upload: '{{ translate('Resume upload') }}',
           pause_upload: '{{ translate('Pause upload') }}',
           retry_upload: '{{ translate('Retry upload') }}',
           cancel_upload: '{{ translate('Cancel upload') }}',
           uploading: '{{ translate('Uploading') }}',
           processing: '{{ translate('Processing') }}',
           complete: '{{ translate('Complete') }}',
           file: '{{ translate('File') }}',
           files: '{{ translate('Files') }}',
           upload_maximum_five_files: '{{ translate('You can only upload a maximum of 10 files.') }}',
       }
   </script>
   <style>
       @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;600;700&display=swap');
   </style>


    <style>
        :root{
            --blue: #3490f3;
            --gray: #9d9da6;
            --gray-dark: #8d8d8d;
            --secondary: #919199;
            --soft-secondary: rgba(145, 145, 153, 0.15);
            --success: #85b567;
            --soft-success: rgba(133, 181, 103, 0.15);
            --warning: #f3af3d;
            --soft-warning: rgba(243, 175, 61, 0.15);
            --light: #f5f5f5;
            --soft-light: #dfdfe6;
            --soft-white: #b5b5bf;
            --dark: #292933;
            --soft-dark: #1b1b28;
        }
    </style>


   

</head>
<body>
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column bg-white">

        <!-- Header -->
        @include('user_layout.inc.nav')

        @yield('content')

        {{-- @include('frontend.inc.footer') --}}

    </div>

 

   
{{-- 
    @include('frontend.partials.modal')
    
    @include('frontend.partials.account_delete_modal') --}}

    <div class="modal fade" id="addToCart">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader text-center p-3">
                    <i class="las la-spinner la-spin la-3x"></i>
                </div>
                <button type="button" class="close absolute-top-right btn-icon close z-1 btn-circle bg-gray mr-2 mt-2 d-flex justify-content-center align-items-center" data-dismiss="modal" aria-label="Close" style="background: #ededf2; width: calc(2rem + 2px); height: calc(2rem + 2px);">
                    <span aria-hidden="true" class="fs-24 fw-700" style="margin-left: 2px;">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>
    

    {{-- <div id="bannerformmodal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="bannerformmodal" aria-hidden="true"> --}}

    @yield('modal')

    <!-- SCRIPTS -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> --}}
    <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> --}}
    <script src="{{ static_asset('assets/js/custom-core.js?v=') }}{{ rand(1000,9999) }}"></script>
    <script>
        $('#search').on('keyup', function(){
            search();
        });

        $('#search').on('focus', function(){
            search();
        });

        function search(){
            var searchKey = $('#search').val();
            
            if(searchKey.length > 0){
                $('body').addClass("typed-search-box-shown");

                $('.typed-search-box').removeClass('d-none');
                $('.search-preloader').removeClass('d-none');
                $.post('{{ route('search.ajax') }}', { _token: AIZ.data.csrf, search:searchKey}, function(data){
                    if(data == '0'){
                        // $('.typed-search-box').addClass('d-none');
                        $('#search-content').html(null);
                        $('.typed-search-box .search-nothing').removeClass('d-none').html('{{ translate('Sorry, nothing found for') }} <strong>"'+searchKey+'"</strong>');
                        $('.search-preloader').addClass('d-none');

                    }
                    else{
                        $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                        $('#search-content').html(data);
                        $('.search-preloader').addClass('d-none');
                    }
                });
            }
            else {
                $('.typed-search-box').addClass('d-none');
                $('body').removeClass("typed-search-box-shown");
            }
        }
    </script>
    
    @yield('script')
    @stack('append-scripts') 
</body>
</html>
