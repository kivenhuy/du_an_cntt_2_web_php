<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0"
            data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            {{-- <div class="d-flex justify-content-around align-items-center align-items-stretch ml-3">
                <div class="aiz-topbar-item">
                    <div class="d-flex align-items-center">
                        <a class="btn btn-soft-danger btn-sm d-flex align-items-center"
                            href="{{ route('cache.clear') }}">
                            <i class="las la-hdd fs-20"></i>
                            <span class="fw-500 ml-1 mr-0 d-none d-md-block">{{ translate('Clear Cache') }}</span>
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown" id="js-dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-0 d-flex justify-content-center align-items-center">
                            <span class="d-flex align-items-center position-relative">
                                <i class="las la-bell fs-24"></i>
                                
                            </span>
                        </span>
                    </a>

                    {{-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xl py-0">
                        <div class="notifications">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-dark active" data-toggle="tab" data-type="order" href="#orders-notifications"
                                        role="tab" id="orders-tab">
                                        {{ translate('Orders') }} <span class="badge badge-primary badge-pill">{{ auth()->user()->unreadNotifications()->where('type', 'App\Notifications\OrderNotification')->count() }}</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller"
                                        href="#sellers-notifications" role="tab" id="sellers-tab">
                                        {{ translate('Sellers') }} <span class="badge badge-primary badge-pill">{{ auth()->user()->unreadNotifications()->where('type', 'like', '%shop%')->count() }}</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller"
                                        href="#payouts-notifications" role="tab" id="sellers-tab">
                                        {{ translate('Payouts') }}  <span class="badge badge-primary badge-pill">{{ auth()->user()->unreadNotifications()->where('type', 'App\Notifications\PayoutNotification')->count() }}</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller"
                                        href="#user-register-notifications" role="tab" id="sellers-tab">
                                        {{ translate('General') }}  <span class="badge badge-primary badge-pill">{{ auth()->user()->unreadNotifications()->whereIn('type', ['App\Notifications\UserRegisteredNotification', 'App\Notifications\RefundNotification', 'App\Notifications\RFQNotification'])->count() }}</span> 
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content c-scrollbar-light overflow-auto" style="height: 75vh; max-height: 400px; overflow-y: auto;">
                                <div class="tab-pane active" id="orders-notifications" role="tabpanel">
                                    <x-notification :notifications="auth()->user()->notifications()->where('type', 'App\Notifications\OrderNotification')->take(30)->get()" is_linkable/>
                                </div>
                                <div class="tab-pane" id="sellers-notifications" role="tabpanel">
                                    <x-notification :notifications="auth()->user()->notifications()->where('type', 'like', '%shop%')->take(30)->get()" is_linkable />
                                </div>
                                <div class="tab-pane" id="payouts-notifications" role="tabpanel">
                                    <x-notification :notifications="auth()->user()->notifications()->where('type', 'App\Notifications\PayoutNotification')->take(30)->get()" is_linkable/>
                                </div>
                                <div class="tab-pane" id="user-register-notifications" role="tabpanel">
                                    <x-notification :notifications="auth()->user()->notifications()->whereIn('type', ['App\Notifications\UserRegisteredNotification', 'App\Notifications\RefundNotification', 'App\Notifications\RFQNotification'])->take(30)->get()" is_linkable/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center border-top">
                            <a href="{{ route('admin.all-notification') }}" class="text-reset d-block py-2">
                                {{ translate('View All Notifications') }}
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>

            {{-- language --}}

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar avatar-sm mr-md-2">
                                <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{ Auth::user()->name }}</span>
                                <span class="d-block small opacity-60">{{ Auth::user()->user_type }}</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        {{-- <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{ translate('Profile') }}</span>
                        </a> --}}

                        <a href="{{ route('admin.logout') }}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>{{ translate('Logout') }}</span>
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->

<style>
    .dropdown-menu.dropdown-menu-xl {
        width: 410px;
        min-width: 405px;
    }
</style>

@push('append-scripts')
    <script type="text/javascript">
        $('.dropdown').on('hide.bs.dropdown', e => {
            let $clicked = $(e.clickEvent.target);
            let $class = $clicked.attr('class');
            
            if ($class.includes('nav-link')) {
                e.preventDefault();
            }
        });
    </script>
@endpush
