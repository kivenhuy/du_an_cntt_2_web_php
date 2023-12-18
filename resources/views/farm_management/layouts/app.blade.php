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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- aiz core css -->
	<link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/custom-seller.css') }}">

    <style>
        body {
            font-size: 12px;
        }
        #map{
            width: 100%;
            height: 250px;
        }
        #edit_map{
            width: 100%;
            height: 250px;
        }
        .pac-container{
            z-index: 100000;
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
        @include('farm_management.inc.farm_management_sidenav')
		<div class="aiz-content-wrapper">
            @include('farm_management.inc.farm_management_nav')
			<div class="aiz-main-content">
				<div class="px-15px px-lg-25px">
                    @yield('panel_content')
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
    </script>

</body>
</html>
