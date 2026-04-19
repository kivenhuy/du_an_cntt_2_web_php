@extends('user_layout.layouts.app')

@section('content')
<section class="mb-5 pt-4">
    <div class="container" style="max-width:1200px">


        {{-- Category grid --}}
        <div class="row">
            @forelse($categories as $category)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <a href="{{ route('products.category', $category->slug) }}"
                       class="d-block text-center text-dark category-card-link">
                        <div class="category-card-logo mx-auto mb-2">
                            @if($category->icon)
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                     data-src="{{ uploaded_asset($category->icon) }}"
                                     alt="{{ $category->name }}"
                                     class="img-fluid lazyload category-logo-img"
                                     onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            @else
                                <div class="category-logo-placeholder d-flex align-items-center justify-content-center">
                                    <span class="category-initials">{{ mb_strtoupper(mb_substr($category->name, 0, 2)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="category-card-name">{{ $category->name }}</div>
                        <div class="category-card-count text-muted">{{ $category->products_count }} {{ translate('sản phẩm') }}</div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fa fa-folder-open fa-3x mb-3 d-block"></i>
                    <p>{{ translate('Chưa có danh mục nào.') }}</p>
                </div>
            @endforelse
        </div>

    </div>
</section>
@endsection

@section('style')
<style>
.category-card-link { text-decoration: none; }
.category-card-logo {
    width: 110px;
    height: 110px;
    border: 1px solid #eaeaea;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: box-shadow .2s, transform .2s;
}
.category-card-link:hover .category-card-logo {
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    transform: translateY(-3px);
}
.category-logo-img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}
.category-logo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f4ff, #dce8ff);
}
.category-initials {
    font-size: 1.6rem;
    font-weight: 700;
    color: #5a7bd5;
}
.category-card-name {
    font-size: .9rem;
    font-weight: 600;
    margin-top: 6px;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.category-card-count {
    font-size: .75rem;
    margin-top: 2px;
}
</style>
@endsection
