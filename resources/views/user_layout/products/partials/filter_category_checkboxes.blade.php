@php
    $selected_categories = $selected_categories ?? [];
    $category_id = $category_id ?? null;
    $category_filter_locked = $category_filter_locked ?? false;
    $isDefaultCategoryContext = ! $category_filter_locked
        && $category_id !== null
        && $selected_categories === [];
@endphp
<div class="product-filter-chips px-3 pb-3">
    @forelse ($filter_categories as $category)
        @php
            $checkboxChecked = $category_filter_locked
                || in_array($category->id, $selected_categories, true)
                || ($isDefaultCategoryContext && (int) $category->id === (int) $category_id);
        @endphp
        <label class="product-filter-chip mb-2 mr-2 @if ($category_filter_locked) product-filter-chip-locked @endif">
            <input
                type="checkbox"
                @unless ($category_filter_locked) name="selected_categories[]" @endunless
                value="{{ $category->id }}"
                class="product-filter-chip-input"
                @if ($checkboxChecked) checked @endif
                @if ($category_filter_locked) disabled @endif
            >
            <span class="product-filter-chip-face">{{ $category->name }}</span>
        </label>
    @empty
        <p class="text-muted fs-14 mb-0">{{ translate('No categories') }}</p>
    @endforelse
</div>
