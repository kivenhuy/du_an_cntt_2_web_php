<!doctype html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

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
        AIZ.local = {}
	</script>

</head>
<body class="">

	<div class="aiz-main-wrapper">
        @include('seller.inc.seller_sidenav')
		<div class="aiz-content-wrapper">
            @include('seller.inc.seller_nav')
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
	    
       
    </script>

</body>
</html>
