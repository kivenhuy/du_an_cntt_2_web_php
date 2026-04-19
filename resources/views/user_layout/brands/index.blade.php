@extends('user_layout.layouts.app')

@section('content')
<section class="mb-5 pt-4">
    <div class="container" style="max-width:1200px">
        {{-- Alphabet nav --}}
        <div class="bg-white rounded shadow-sm p-3 mb-4">
            <div class="d-flex flex-wrap gap-2" style="gap:6px">
                @foreach($alphabet as $letter)
                    @php $hasData = $grouped->has($letter); @endphp
                    <a href="{{ $hasData ? '#brand-group-'.$letter : '#' }}"
                       class="btn btn-sm {{ $hasData ? 'btn-primary' : 'btn-outline-secondary' }} px-3"
                       style="min-width:40px;font-weight:600;{{ !$hasData ? 'opacity:.4;cursor:default;pointer-events:none' : '' }}">
                        {{ $letter }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Brand groups --}}
        @forelse($grouped as $letter => $brandsInGroup)
            <div id="brand-group-{{ $letter }}" class="mb-5">
                <h4 class="fw-700 border-bottom pb-2 mb-3" style="color:#333">{{ $letter }}</h4>
                <div class="row">
                    @foreach($brandsInGroup as $brand)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                            <a href="{{ route('brands.show', $brand->slug) }}"
                               class="d-block text-center text-dark brand-card-link">
                                <div class="brand-card-logo mx-auto mb-2">
                                    @if($brand->logo)
                                        <img src="{{ uploaded_asset($brand->logo) }}"
                                             alt="{{ $brand->name }}"
                                             class="img-fluid brand-logo-img">
                                    @else
                                        <div class="brand-logo-placeholder d-flex align-items-center justify-content-center">
                                            <span class="brand-initials">{{ mb_strtoupper(mb_substr($brand->name, 0, 2)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="brand-card-name">{{ $brand->name }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="fa fa-tag fa-3x mb-3 d-block"></i>
                <p>Chưa có thương hiệu nào.</p>
            </div>
        @endforelse

    </div>
</section>
@endsection

@section('style')
<style>
.brand-card-link { text-decoration: none; }
.brand-card-logo {
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
.brand-card-link:hover .brand-card-logo {
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    transform: translateY(-3px);
}
.brand-logo-img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}
.brand-logo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f4ff, #dce8ff);
}
.brand-initials {
    font-size: 1.6rem;
    font-weight: 700;
    color: #5a7bd5;
}
.brand-card-name {
    font-size: .875rem;
    font-weight: 600;
    margin-top: 6px;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endsection
