<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" name="" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                
                {{-- Dashboard --}}
                {{-- @can('admin_dashboard') --}}
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                        <i class="fa fa-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                    </a>
                </li>
                {{-- @endcan --}}
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa-solid fa-box aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Address</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('country.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Country</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('city.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">City</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('district.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">District</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{route('categories.index')}}" class="aiz-side-nav-link">
                        <i class="fa fa-mortar-pestle aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Category')}}</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa-solid fa-box aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Products</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">All Products</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa fa-user aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.sellers.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa fa-industry aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Enterprise') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.enterprise.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{ translate('All Enterprise') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
