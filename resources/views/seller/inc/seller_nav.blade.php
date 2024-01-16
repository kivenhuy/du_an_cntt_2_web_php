<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex  align-items-center align-items-stretch" style="width: 90%;justify-content: flex-end;">

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-0 d-flex justify-content-center align-items-center">
                            <span class="d-flex align-items-center position-relative">
                                <i class="fa-regular fa-bell" style="font-size: 24px"></i>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right" style="top: -6px">{{Auth::user()->unreadNotifications->count()}}</span>
                                @endif
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg py-0">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                        </div>
                        <div class=" c-scrollbar-light overflow-auto " style="max-height:300px;">
                            <ul class="list-group list-group-flush">
                                @forelse(Auth::user()->unreadNotifications->take(20) as $notification)
                                    <li class="list-group-item d-flex justify-content-between align-items- py-3">
                                        <div class="media text-inherit">
                                            <div class="media-body">
                                                @if($notification->type == 'App\Notifications\WelcomeNotification')
                                                    <p class="mb-1 text-truncate-2">
                                                        <a href="{{route('request_for_product.get_details_data',['id'=>$notification->data['request_id']])}}">
                                                            @if($notification->data['status'] === 0)
                                                                {{$notification->data['user_id']}} {{translate('has new request product,request code: ')}} {{$notification->data['request_code']}}
                                                            @elseif($notification->data['status'] === 1)
                                                                {{translate('Admin has approve for request product, request code: ')}} {{$notification->data['request_code']}}
                                                            @elseif($notification->data['status'] === 3)
                                                                {{$notification->data['user_id']}} {{translate('has approve price for request product, request code: ')}} {{$notification->data['request_code']}}
                                                            @else
                                                            @endif
                                                        </a>
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ date("F j Y, g:i a", strtotime($notification->created_at) + 60*60*7 ) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item">
                                        <div class="py-4 text-center fs-16">
                                            {{ translate('No notification found') }}
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="text-center border-top">
                            <a href="" class="text-reset d-block py-2">
                                {{translate('View All Notifications')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown " id="lang-change">
                    
                   
                </div>
            </div>

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar avatar-sm mr-md-2">
                                <img
                                    src="{{ uploaded_asset(Auth::user()->shop->logo) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                                >
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500">{{Auth::user()->name}}</span>
                                <span class="d-block small opacity-60">{{Auth::user()->user_type}}</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{ route('seller.dashboard') }}" class="dropdown-item">
                            <i class="fa fa-home"></i>
                            <span>{{translate('Ecom Dashboard')}}</span>
                        </a>

                       

                        <a href="{{ route('seller.logout')}}" class="dropdown-item">
                            <i class="fa fa-sign-out"></i>
                            <span>{{translate('Logout')}}</span>
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->
