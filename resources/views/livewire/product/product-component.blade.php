<div>
    <div class="grid -mx-2 sm:grid-cols-3">
        @foreach ($products as $product)
            @livewire('product.card-prefer-component', ['product' => $product], ['key' => $product->id])
        @endforeach
    </div>

    <div class="pt-2 mt-2">{{ $products->links() }}</div>
</div>

