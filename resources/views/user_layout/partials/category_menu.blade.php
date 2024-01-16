<div class="aiz-category-menu bg-white rounded-0 border-top" id="category-sidebar" style="height: 480px;margin-right: 21px;max-width:258.25px;width:100%;border: 1px solid;border-radius: 10px !important;">
    <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
        @foreach (\App\Models\Category::get()->take(10) as $key => $category)
            <li class="category-nav-element border-top-0" data-id="{{ $category->id }}">
                <a href="{{ route('products.category', $category->slug) }}" class="form_left_side text-dark px-4 fs-15 d-block hov-column-gap-1">
                    <img class="cat-image lazyload mr-2 opacity-60"
                        style="margin-right: 12px !important;"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($category->icon) }}"
                        width="24"
                        alt=""
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    <span class="cat-name has-transition">{{ $category->name }}</span>
                </a>
                 
            </li>
        @endforeach
    </ul>
</div>
