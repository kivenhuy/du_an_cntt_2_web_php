<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <div class="d-block text-center my-3">
                @if ((Auth::user()->shop)->logo != null)
                    <img class="mw-100 mb-3" src="{{ uploaded_asset((Auth::user()->shop)->logo) }}"
                        class="brand-icon" >
                @else
                    <img class="mw-100 mb-3" src="{{ uploaded_asset(0) }}" class="brand-icon"
                        alt="">
                @endif
                <h3 class="fs-16  m-0 text-primary">{{ optional(Auth::user()->shop)->name }}</h3>
                <p class="text-primary">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm" type="text" name=""
                    placeholder="Search in menu" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('seller.dashboard') }}" class="aiz-side-nav-link">
                        <i class="fa fa-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Dashboard'</span>
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
                            <a href="{{ route('seller.products') }}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['seller.products', 'seller.products.create']) }}">
                                <span class="aiz-side-nav-text">Products</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa-solid fa-box aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Request For Product</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{route('request_for_product.seller_index')}}" class="aiz-side-nav-link">
                                <i class="fa fa-list aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Ecom Request')}}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{route('request_for_product.seller_supermarket_index')}}" class="aiz-side-nav-link">
                                <i class="fa fa-list aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Super Market Request')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="aiz-side-nav-item">
                    <a href="{{ route('seller.shop.index') }}" class="aiz-side-nav-link">
                        <i class="fa fa-cog aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Shop Setting</span>
                    </a>
                </li>

            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div>