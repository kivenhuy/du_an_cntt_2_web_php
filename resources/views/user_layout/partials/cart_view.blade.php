@extends('user_layout.layouts.app')

@section('content')
    

    <!-- Cart Details -->
    <section class="mb-4" id="cart-summary">
        @include('user_layout.partials.cart_details', ['carts' => $carts])
    </section>

@endsection
@section('modal')
    {{-- New Address Modal --}}
    
@endsection
@section('script')

    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {
            $.post('{{ route('cart.updateQuantity') }}', {
                _token: AIZ.data.csrf,
                id: key,
                quantity: element.value
            }, function(data) {
                updateNavCart(data.nav_cart_view, data.cart_count);
                $('#cart-summary').html(data.cart_view);
            });
        }
    </script>
@endsection
