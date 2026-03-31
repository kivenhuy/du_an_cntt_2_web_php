@php
    $selected_brands = $selected_brands ?? [];
@endphp
<div class="product-filter-chips px-3 pb-3">
    @forelse ($filter_brands as $brand)
        @php
            $brandChecked = in_array($brand->id, $selected_brands, true);
        @endphp
        <label class="product-filter-chip mb-2 mr-2">
            <input
                type="checkbox"
                name="selected_brands[]"
                value="{{ $brand->id }}"
                class="product-filter-chip-input"
                @if ($brandChecked) checked @endif
            >
            <span class="product-filter-chip-face">{{ $brand->name }}</span>
        </label>
    @empty
        <p class="text-muted fs-14 mb-0">{{ translate('No brands') }}</p>
    @endforelse
</div>
