<!doctype html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    {{-- Font Awsomer --}}
	{{-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
	<link rel="stylesheet" href="{{ static_asset('assets/css/custom-style.css?v=') }}{{ now()->timestamp }}">


	{{-- Toast --}}
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- alpha/css/bootstrap.css" rel="stylesheet">
   
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   	<link rel="stylesheet" type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
   	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	@yield('style')
    <style>
        body {
            font-size: 12px;
        }
    </style>
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

</head>
<body class="">
	
	<div class="aiz-main-wrapper">
        @include('admin.inc.admin_sidenav')
		<div class="aiz-content-wrapper">
            @include('admin.inc.admin_nav')
			<div class="aiz-main-content">
				<div class="px-15px px-lg-25px">
                    @yield('content')
				</div>
				<div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
					
				</div>
			</div><!-- .aiz-main-content -->
		</div><!-- .aiz-content-wrapper -->
	</div><!-- .aiz-main-wrapper -->

    @yield('modal')


	<script src="{{ static_asset('assets/js/vendors.js') }}" ></script>
	<script src="{{ static_asset('assets/js/custom-core.js') }}" ></script>
	<script src="{{ static_asset('plugins/jquery-validation/jquery.validate.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables/jquery.dataTables.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}" ></script>

    @yield('script')
	
	@stack('append-scripts')

    <script type="text/javascript">
	    @foreach (session('flash_notification', collect())->toArray() as $message)
	        AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
	    @endforeach


        function menuSearch(){
			var filter, item;
			filter = $("#menu-search").val().toUpperCase();
			items = $("#main-menu").find("a");
			items = items.filter(function(i,item){
				if($(item).find(".aiz-side-nav-text")[0].innerText.toUpperCase().indexOf(filter) > -1 && $(item).attr('href') !== '#'){
					return item;
				}
			});

			if(filter !== ''){
				$("#main-menu").addClass('d-none');
				$("#search-menu").html('')
				if(items.length > 0){
					for (i = 0; i < items.length; i++) {
						const text = $(items[i]).find(".aiz-side-nav-text")[0].innerText;
						const link = $(items[i]).attr('href');
						 $("#search-menu").append(`<li class="aiz-side-nav-item"><a href="${link}" class="aiz-side-nav-link"><i class="las la-ellipsis-h aiz-side-nav-icon"></i><span>${text}</span></a></li`);
					}
				}else{
					$("#search-menu").html(`<li class="aiz-side-nav-item"><span	class="text-center text-muted d-block">{{ translate('Nothing Found') }}</span></li>`);
				}
			}else{
				$("#main-menu").removeClass('d-none');
				$("#search-menu").html('')
			}
        }
    </script>

</body>
</html>
