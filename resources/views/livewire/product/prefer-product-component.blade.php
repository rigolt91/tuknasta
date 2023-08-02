<div>
    <div class="grid grid-cols-1 -mx-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            <livewire:product.card-prefer-component :product="$product" :key="$product->id">
        @endforeach
    </div>
</div>
