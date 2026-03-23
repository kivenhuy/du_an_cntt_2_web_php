    <!-- Top Bar -->
    <div class="top-navbar bg-white z-1035 h-35px h-sm-auto">
       
    </div>
    
    
    <header class="sticky-top z-1020 bg-white">
        <!-- Search Bar -->
        <input type="hidden" id="shop_id" value="">
        <div class="position-relative logo-bar-area border-bottom border-md-nonea z-1025 search_bar">
            <div class="container">
                <div class="d-flex align-items-center">
                    <!-- top menu sidebar button -->
                    <button type="button" class="btn d-lg-none mr-3 mr-sm-4 p-0 active" data-toggle="class-toggle"
                        data-target=".aiz-top-menu-sidebar">
                        <svg id="Component_43_1" data-name="Component 43 – 1" xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" viewBox="0 0 16 16">
                            <rect id="Rectangle_19062" data-name="Rectangle 19062" width="16" height="2"
                                transform="translate(0 7)" fill="#919199" />
                            <rect id="Rectangle_19063" data-name="Rectangle 19063" width="16" height="2"
                                fill="#919199" />
                            <rect id="Rectangle_19064" data-name="Rectangle 19064" width="16" height="2"
                                transform="translate(0 14)" fill="#919199" />
                        </svg>

                    </button>
                    <!-- Header Logo -->
                    <div class="col-auto pl-0 pr-3 d-flex align-items-center">
                        <a href="{{route('homepage')}}">
                            <img src="{{ static_asset('assets/img/DTQSbmTVlRIyc56RV4e98YWpf1fa9dfsKYb2IojK.jpg') }}" alt="" class="mw-100 h-30px h-md-65px" style="height: 90px;width: 90px;">
                        </a>
                    </div>
                    <!-- Search Icon for small device -->
                    <div class="d-lg-none ml-auto mr-0">
                        <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle"
                            data-target=".front-header-search">
                            <i class="las la-search la-flip-horizontal la-2x"></i>
                        </a>
                    </div>
                    <!-- Search field -->
                    <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white mx-xl-5" style="flex-direction: column;">
                        <div class="position-relative flex-grow-1 px-3 px-lg-0" style="width: 100% !important">
                            <form action="" method="GET" class="stop-propagation">
                                <div class="d-flex position-relative align-items-center">
                                    <div class="d-lg-none" data-toggle="class-toggle"
                                        data-target=".front-header-search">
                                        <button class="btn px-2" type="button"><i
                                                class="la la-2x la-long-arrow-left"></i></button>
                                    </div>
                                    <div class="search-input-box">
                                        <input type="text"
                                            class="border border-soft-light form-control fs-14 hov-animate-outline"
                                            id="search" name="keyword"
                                            {{-- @isset($query)
                                                value="{{ $query }}"
                                            @endisset --}}
                                            placeholder="I am shopping for..." autocomplete="off">

                                        <svg id="Group_723" data-name="Group 723" xmlns="http://www.w3.org/2000/svg"
                                            width="20.001" height="20" viewBox="0 0 20.001 20">
                                            <path id="Path_3090" data-name="Path 3090"
                                                d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z"
                                                transform="translate(-1.854 -1.854)" fill="#b5b5bf" />
                                            <path id="Path_3091" data-name="Path 3091"
                                                d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z"
                                                transform="translate(-5.2 -5.2)" fill="#b5b5bf" />
                                        </svg>
                                    </div>
                                </div>
                            </form>
                            <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
                                style="min-height: 200px">
                                <div class="search-preloader absolute-top-center">
                                    <div class="dot-loader">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="search-nothing d-none p-3 text-center fs-16">

                                </div>
                                <div id="search-content" class="text-left">

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search box -->
                    <div class="d-none d-lg-none ml-3 mr-0">
                        <div class="nav-search-box">
                            <a href="#" class="nav-box-link">
                                <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Cart -->
                    <div class="d-none d-xl-block align-self-stretch ml-5 mr-0 has-transition bg-black-10"
                        data-hover="dropdown" style="
                        background-color: white !important;">
                        @auth
                            <div class="nav-cart-box dropdown h-100" id="cart_items" style="width: max-content;">
                                @include('user_layout.partials.cart')
                            </div>
                        @endauth
                    </div>
                    <!-- Compare -->
                    <div class="d-none d-lg-block ml-3 mr-0">
                        <div class="icon_header" id="compare">
                        </div>
                    </div>
                    <!-- Wishlist -->
                    <div class="d-none d-lg-block mr-3" style="margin-left: 36px;">
                        <div class="icon_header" id="wishlist">
                        </div>
                    </div>

                    {{-- Notification --}}
                    @if ( Auth::check() && (Auth::user()->user_type == "customer" || Auth::user()->user_type == "enterprise"))
                        <!-- Notifications -->
                        <ul class="list-inline mb-0 h-100 d-none d-xl-flex justify-content-end align-items-center">
                            <li class="list-inline-item ml-3 mr-3 pr-3 pl-0 dropdown">
                                <a class="dropdown-toggle no-arrow text-secondary fs-12" data-toggle="dropdown"
                                    href="javascript:void(0);" role="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    <span class="">
                                        <span class="position-relative d-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14.668" height="16"
                                                viewBox="0 0 14.668 16">
                                                <path id="_26._Notification" data-name="26. Notification"
                                                    d="M8.333,16A3.34,3.34,0,0,0,11,14.667H5.666A3.34,3.34,0,0,0,8.333,16ZM15.06,9.78a2.457,2.457,0,0,1-.727-1.747V6a6,6,0,1,0-12,0V8.033A2.457,2.457,0,0,1,1.606,9.78,2.083,2.083,0,0,0,3.08,13.333H13.586A2.083,2.083,0,0,0,15.06,9.78Z"
                                                    transform="translate(-0.999)" fill="#91919b" />
                                            </svg>
                                            @if (Auth::check() && count(Auth::user()->unreadNotifications)>0)
                                                <span
                                                    class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{count(Auth::user()->unreadNotifications)}}</span>
                                            @endif
                                        </span>
                                </a>

                                @auth
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0 rounded-0">
                                        <div class="p-3 bg-light border-bottom">
                                            <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                                        </div>
                                        <div class=" c-scrollbar-light overflow-auto " style="max-height:300px;">
                                            <ul class="list-group list-group-flush">
                                                @if(count(Auth::user()->unreadNotifications)>0)
                                                    @forelse(Auth::user()->unreadNotifications as $notification)
                                                        <li class="list-group-item">
                                                            
                                                            @if ($notification->type == 'App\Notifications\OrderNotification')
                                                                {{-- @if (Auth::user()->user_type == 'enterpriese') --}}
                                                                @php
                                                                    $order = App\Models\OrderDetail::find($notification->data['order_detail_id']);
                                                                    if($order)
                                                                    {
                                                                        $order =$order->order;
                                                                    }
                                                                    else {
                                                                        break;
                                                                    }
                                                                @endphp
                                                                    <a href="{{ route('purchase_history.get_detail', encrypt($order->id))}}" 
                                                                        class="text-secondary fs-14">
                                                                        @if($notification->data['status'] == "receive_order")
                                                                            <span class="order_notification">
                                                                                {{ translate('Order code: ') }}
                                                                                {{ $order->code }}
                                                                                {{ translate('has been ' . (str_replace('_', ' ', $notification->data['status']))) }}
                                                                                by shipper {{ $notification->data['shipper_name'] }}
                                                                            </span>
                                                                        @elseif($notification->data['status'] == "order_picking")
                                                                            <span class="order_notification">
                                                                                Shipper {{ $notification->data['shipper_name'] }} doing order picking
                                                                                {{ translate('order code: ') }} {{ $order->code }}
                                                                            </span>
                                                                        @elseif($notification->data['status'] == "shipping")
                                                                            <span class="order_notification">
                                                                                Shipper {{ $notification->data['shipper_name'] }} is on the way to deliver
                                                                                {{ translate('order code: ') }} {{ $order->code }}
                                                                            </span>
                                                                        @elseif($notification->data['status'] == "delivered")
                                                                            <span class="order_notification">
                                                                                Shipper {{ $notification->data['shipper_name'] }} delivered successfully {{ translate('Order code: ') }} {{ $order->code }}
                                                                            </span>
                                                                        @elseif($notification->data['status'] == "fail")
                                                                            <span class="order_notification">
                                                                                Order status has been fail because delivery time does not meet standards  {{ translate('Order code: ') }} {{ $order->code }}
                                                                            </span>
                                                                        @endif
                                                                    </a>
                                                                {{-- @elseif(Auth::user()->user_type == 'enterpriese') --}}
                                                                {{-- @elseif (Auth::user()->user_type == 'seller')
                                                                    <a href="{{ route('seller.orders.show', encrypt($notification->data['order_id'])) }}"
                                                                        class="text-secondary fs-12">
                                                                        <span class="ml-2">
                                                                            {{ translate('Order code: ') }}
                                                                            {{ $notification->data['order_code'] }}
                                                                            {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                                        </span>
                                                                    </a>
                                                                @endif --}}
                                                            @elseif ($notification->type == 'App\Notifications\RefundNotification')
                                                                <a href="{{ route('refund.detail', ($notification->data['request_id']))}}" class="text-secondary fs-14">
                                                                    <span class="order_notification">
                                                                        {{ translate('Your refund request for order have code: ') }}
                                                                        {{ $notification->data['request_code'] }}
                                                                        @if($notification->data['status'] == 1)
                                                                            {{ translate('has been approved by admin')}}
                                                                        @elseif($notification->data['status'] == 2)
                                                                            {{ translate('has been refunded by admin')}}
                                                                        @else
                                                                            {{ translate('has been rejected by admin')}}
                                                                        @endif
                                                                        
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('request_for_product.get_details_data', ($notification->data['request_id']))}}" class="text-secondary fs-14">
                                                                    <span class="order_notification">
                                                                        {{ translate('Your request for product have code: ') }}
                                                                        {{ $notification->data['request_code'] }}
                                                                        @if($notification->data['status'] == 1)
                                                                            {{ translate('has been approved by admin')}}
                                                                        @elseif($notification->data['status'] == 2)
                                                                            {{ translate('has been approved by seller')}}
                                                                        @elseif($notification->data['status'] == 90)
                                                                            {{ translate('has been rejected by seller')}}
                                                                        @else
                                                                            {{ translate('seller has been update price')}}
                                                                        @endif
                                                                        
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @empty
                                                        
                                                    @endforelse
                                                @else
                                                    <li class="list-group-item">
                                                        <div class="py-4 text-center fs-16">
                                                            {{ translate('No notification found') }}
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="text-center border-top">
                                            <a href=""
                                                class="text-secondary fs-12 d-block py-2">
                                                {{ translate('View All Notifications') }}
                                            </a>
                                        </div>
                                    </div>
                                @endauth
                            </li>
                        </ul>
                    @endif

                    {{-- Account --}}
                    <div class="ml-auto mr-0 d-none d-xl-block">
                        @auth
                            <span class="d-none d-xl-flex align-items-center nav-user-info py-20px" id="nav-user-info">
                                <!-- Image -->
                                <span
                                    class="size-40px overflow-hidden border border-transparent nav-user-img">
                                    @if (Auth::user()->avatar_original != null)
                                        <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                                            class="img-fit h-100"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                    @else
                                        <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                    @endif
                                </span>
                                <!-- Name -->
                                <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ Auth::user()->name }}</h4>
                            </span>
                        @else
                            <!--Login & Registration -->
                            <span class="d-none d-xl-flex align-items-center nav-user-info ml-3">
                                <!-- Image -->
                                <span
                                    class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012"
                                        viewBox="0 0 19.902 20.012">
                                        <path id="fe2df171891038b33e9624c27e96e367"
                                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"
                                            transform="translate(-2.064 -1.995)" fill="#91919b" />
                                    </svg>
                                </span>
                                <a href="{{ route('user.login') }}"
                                    class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login') }}</a>
                                <a href="{{ route('user.registration_form') }}"
                                    class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Register') }}</a>
                            </span>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Loged in user Menus -->
            <div class="hover-user-top-menu position-absolute top-100 right-0 left-0 z-3">
                <div class="container">
                    <div class="position-static float-right">
                        <div class="aiz-user-top-menu bg-white rounded-0 border-top shadow-sm" style="width:220px;">
                            <ul class="list-unstyled no-scrollbar mb-0 text-left">
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('user.dashboard') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="Group_25261" data-name="Group 25261" transform="translate(-27.466 -542.963)">
                                                <path id="Path_2953" data-name="Path 2953" d="M14.5,5.963h-4a1.5,1.5,0,0,0,0,3h4a1.5,1.5,0,0,0,0-3m0,2h-4a.5.5,0,0,1,0-1h4a.5.5,0,0,1,0,1" transform="translate(22.966 537)" fill="#b5b5bf"></path>
                                                <path id="Path_2954" data-name="Path 2954" d="M12.991,8.963a.5.5,0,0,1,0-1H13.5a2.5,2.5,0,0,1,2.5,2.5v10a2.5,2.5,0,0,1-2.5,2.5H2.5a2.5,2.5,0,0,1-2.5-2.5v-10a2.5,2.5,0,0,1,2.5-2.5h.509a.5.5,0,0,1,0,1H2.5a1.5,1.5,0,0,0-1.5,1.5v10a1.5,1.5,0,0,0,1.5,1.5h11a1.5,1.5,0,0,0,1.5-1.5v-10a1.5,1.5,0,0,0-1.5-1.5Z" transform="translate(27.466 536)" fill="#b5b5bf"></path>
                                                <path id="Path_2955" data-name="Path 2955" d="M7.5,15.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5" transform="translate(23.966 532)" fill="#b5b5bf"></path>
                                                <path id="Path_2956" data-name="Path 2956" d="M7.5,21.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5" transform="translate(23.966 529)" fill="#b5b5bf"></path>
                                                <path id="Path_2957" data-name="Path 2957" d="M7.5,27.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5" transform="translate(23.966 526)" fill="#b5b5bf"></path>
                                                <path id="Path_2958" data-name="Path 2958" d="M13.5,16.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(20.966 531.5)" fill="#b5b5bf"></path>
                                                <path id="Path_2959" data-name="Path 2959" d="M13.5,22.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(20.966 528.5)" fill="#b5b5bf"></path>
                                                <path id="Path_2960" data-name="Path 2960" d="M13.5,28.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(20.966 525.5)" fill="#b5b5bf"></path>
                                            </g>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">Dashboard</span>
                                    </a>
                                </li>
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('user.logout') }}"
                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.999"
                                            viewBox="0 0 16 15.999">
                                            <g id="Group_25503" data-name="Group 25503"
                                                transform="translate(-24.002 -377)">
                                                <g id="Group_25265" data-name="Group 25265"
                                                    transform="translate(-216.534 -160)">
                                                    <path id="Subtraction_192" data-name="Subtraction 192"
                                                        d="M12052.535,2920a8,8,0,0,1-4.569-14.567l.721.72a7,7,0,1,0,7.7,0l.721-.72a8,8,0,0,1-4.567,14.567Z"
                                                        transform="translate(-11803.999 -2367)" fill="#d43533" />
                                                </g>
                                                <rect id="Rectangle_19022" data-name="Rectangle 19022" width="1"
                                                    height="8" rx="0.5" transform="translate(31.5 377)"
                                                    fill="#d43533" />
                                            </g>
                                        </svg>
                                        <span
                                            class="user-top-menu-name text-primary has-transition ml-3">{{ translate('Logout') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if(Auth::check()) --}}
        <div class="d-none d-lg-block position-relative bg-primary h-50px" style="height:70px;background-color:#2E7F25 !important">
            <div class="container h-100">
                <div class="d-flex h-100">
                   
                    <div class="ml-xl-4 w-100 overflow-hidden">
                        <div class="d-flex align-items-center justify-content-center justify-content-xl-start h-100">
                            <ul class="list-inline mb-0 pl-0 hor-swipe c-scrollbar-light">
        
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('homepage')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('Home') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('homepage')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('All Seller') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('homepage')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('All Category') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('comming-soon')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('News') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('comming-soon')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('About Us') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('comming-soon')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('Discount') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('comming-soon')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('Support') }}
                                    </a>
                                </li>
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{route('comming-soon')}}"
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10">
                                        {{ translate('Resources') }}
                                    </a>
                                </li>
                               
                            </ul>
                        </div>
                        
                    </div>
                   
                    <!-- Cart -->
                </div>
                
            </div>
            
        </div>
        {{-- @endif --}}
    </header>

