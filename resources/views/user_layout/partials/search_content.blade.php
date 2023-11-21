<div class="">
    @if (sizeof($keywords) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Popular Suggestions')}}</div>
        <ul class="list-group list-group-raw">
            @foreach ($keywords as $key => $keyword)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary" href="">{{ $keyword }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($products) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Products')}}</div>
        <ul class="list-group list-group-raw">
            @foreach ($products as $key => $product)
                <li class="list-group-item">
                    <a class="text-reset" href="{{ route('product', $product->slug) }}">
                        <div class="d-flex search-product align-items-center">
                            <div class="mr-3">
                                <img class="size-40px img-fit rounded" src="">
                            </div>
                            <div class="flex-grow-1 overflow--hidden minw-0">
                                <div class="product-name text-truncate fs-14 mb-5px">
                                    {{  $product->name  }}
                                </div>
                                <div class="price_product_top_selling">
                                    {{"đ " . number_format($product->unit_price, 0, ".", ",")  }}
                                </div>
                                {{-- <div class="">
                                    @if(home_base_price($product) != home_discounted_base_price($product))
                                        <del class="opacity-60 fs-15">{{ home_base_price($product) }}</del>
                                    @endif
                                    <span class="fw-600 fs-16 text-primary">{{ home_discounted_base_price($product) }}</span>
                                </div> --}}
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

