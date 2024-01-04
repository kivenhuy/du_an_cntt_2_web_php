<div class="aiz-user-sidenav-wrap position-relative z-1 rounded-0">
    <div class="aiz-user-sidenav overflow-auto c-scrollbar-light px-4 pb-4">
        <!-- Close button -->
        <div class="d-xl-none">
            <button class="btn btn-sm p-2 " data-toggle="class-toggle" data-backdrop="static"
                data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb">
                <i class="las la-times la-2x"></i>
            </button>
        </div>

        <!-- Customer info -->
        <div class="p-4 text-center mb-4 border-bottom position-relative">
            <!-- Image -->
            <span class="avatar avatar-md mb-3">
                @if (Auth::user()->avatar_original != null)
                    <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                @else
                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image rounded-circle"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                @endif
            </span>
            <!-- Name -->
            <h4 class="h5 fs-14 mb-1 fw-700 text-dark">{{ Auth::user()->name }}</h4>
            <!-- Phone -->
            @if (Auth::user()->phone != null)
                <div class="text-truncate opacity-60 fs-12">{{ Auth::user()->phone }}</div>
            <!-- Email -->
            @else
                <div class="text-truncate opacity-60 fs-12">{{ Auth::user()->email }}</div>
            @endif
        </div>

        <!-- Menus -->
        <div class="sidemnenu">
            <ul class="aiz-side-nav-list mb-3 pb-3 border-bottom" data-toggle="aiz-side-menu">
                
                <!-- Dashboard -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('user.dashboard') }}" class="aiz-side-nav-link {{ areActiveRoutes(['user.dashboard']) }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Dashboard') }}</span>
                    </a>
                </li>

                <!-- Purchase History -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('purchase_history.index') }}"
                        class="aiz-side-nav-link {{ areActiveRoutes(['purchase_history.index', 'purchase_history.details']) }}">
                        
                        <i class="fa fa-history" aria-hidden="true"></i>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Purchase History') }}</span>
                        
                    </a>
                </li>

               <!-- Request For Product -->
               @if(Auth::user()->user_type === "enterprise")
                <li class="aiz-side-nav-item">
                        <a href="{{ route('request_for_product.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['request_for_product.index', 'purchase_history.details']) }}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            <span class="aiz-side-nav-text ml-3">{{ translate('Request For Product') }}</span>
                            
                        </a>
                    </li>
                @endif
                
                <!-- Manage Profile -->
                <li class="aiz-side-nav-item">
                    <a href="{{ route('profile') }}" class="aiz-side-nav-link {{ areActiveRoutes(['profile']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_8094" data-name="Group 8094" transform="translate(3176 -602)">
                              <path id="Path_2924" data-name="Path 2924" d="M331.144,0a4,4,0,1,0,4,4,4,4,0,0,0-4-4m0,7a3,3,0,1,1,3-3,3,3,0,0,1-3,3" transform="translate(-3499.144 602)" fill="#b5b5bf"/>
                              <path id="Path_2925" data-name="Path 2925" d="M332.144,20h-10a3,3,0,0,0,0,6h10a3,3,0,0,0,0-6m0,5h-10a2,2,0,0,1,0-4h10a2,2,0,0,1,0,4" transform="translate(-3495.144 592)" fill="#b5b5bf"/>
                            </g>
                        </svg>
                        <span class="aiz-side-nav-text ml-3">{{ translate('Manage Profile') }}</span>
                    </a>
                </li>
            </ul>
        
            <!-- logout -->
            <a href="{{ route('user.logout') }}" class="btn btn-primary btn-block fs-14 fw-700 mb-5 mb-md-0" style="border-radius: 25px;">{{ translate('Sign Out') }}</a>
        </div>

    </div>
</div>
