<div>
    <div class="grid grid-cols-1 -mx-2 sm:grid-cols-3">
        @foreach ($products as $product)
            @livewire('product.card-prefer', ['product' => $product], ['key' => $product->id])
        @endforeach
    </div>
</div>
