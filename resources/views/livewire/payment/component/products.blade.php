<div>
    <div class="text-gray-800 text-md font-bold border-b uppercase">
        <span>{{__('Products')}}</span>
        <div class="float-right">({{ $total_products }})</div>
    </div>

    @foreach ($carts as $cart)
        <div class="border-b text-gray-700 py-1">
            <span>{{ $cart->product->name }} <span>({{ $cart->units }})</span></span>
            <div class="float-right">${{ number_format(($cart->price * $cart->units) , 2) }}</div>
        </div>
    @endforeach
</div>
