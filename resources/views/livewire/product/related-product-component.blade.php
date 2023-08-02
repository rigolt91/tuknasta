<div>
    @if ($products->count() > 0)
        <div class="grid grid-cols-1 -mx-2 text-sm sm:grid-cols-3">
            @foreach ($products as $product)
                @livewire('product.card-prefer-component', ['product' => $product], ['key' => $product->id])
            @endforeach
        </div>
    @else
        <div class="mt-4 text-gray-800">{{__('There are no related products')}}</div>
    @endif
</div>
