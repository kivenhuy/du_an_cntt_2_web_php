<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                <img src="{{ static_asset('assets/img/logo.jpg') }}" alt="" class="mw-100 h-30px h-md-65px" style="height: 40px;width: 40px;">
                
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
                        <span class="aiz-side-nav-text">Địa chỉ</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('country.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Quốc gia</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('city.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Thành phố</span>
                            </a>
                        </li>
                    </ul>
                    <!-- <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('province.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Tỉnh</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('district.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Quận</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('commune.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Phường/Xã</span>
                            </a>
                        </li>
                    </ul> -->
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{route('categories.index')}}" class="aiz-side-nav-link">
                        <i class="fa fa-mortar-pestle aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Danh mục</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="aiz-side-nav-link">
                        <i class="fa fa-tag aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Thương hiệu</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa fa-image aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Trang chủ</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.home_slides.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">Slide trang chủ</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa-solid fa-box aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Sản phẩm</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Tất cả sản phẩm</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.products.create') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">Thêm sản phẩm</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa fa-users aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Khách hàng</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.customer.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">Tất cả khách hàng</span>
                            </a>
                        </li>
                    </ul>
                </li>

                

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa fa-shopping-cart aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Đơn hàng</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('admin.purchase_history.all_orders') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">Tất cả đơn hàng</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('refund.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">Yêu cầu hoàn trả</span>
                            </a>
                        </li>
                    </ul>
                </li>
                

               
               
                <li class="aiz-side-nav-item">
                    <a href="{{route('carriers.index')}}" class="aiz-side-nav-link">
                        <i class="fa fa-list aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Nhà vận chuyển</span>
                    </a>
                </li>

                
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
