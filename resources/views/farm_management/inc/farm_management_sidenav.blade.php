<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
           
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
                    <a href="{{ route('farm_management.dashboard') }}" class="aiz-side-nav-link">
                        <i class="fa fa-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Dashboard'</span>
                    </a>
                </li>
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="fa-solid fa-box aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Farmer Management</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    {{-- Farmer --}}
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('farmer.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">All Farmer</span>
                            </a>
                        </li>
                    </ul>
                    {{-- Cultivation --}}
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('cultivation.index') }}"
                                class="aiz-side-nav-link ">
                                <span class="aiz-side-nav-text">All Cultivation</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div>