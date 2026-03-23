@extends('user_layout.layouts.app')
@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
			@include('user_layout.inc.user_side_nav')
			<div class="aiz-user-panel">
				@yield('panel_content')
            </div>
        </div>
    </div>
</section>
@endsection