<div>
    <div class="grid grid-cols-2 -mx-2 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($products as $product)
            <livewire:product.card-prefer-component :product="$product" :key="$product->id">
        @endforeach
    </div>
</div>
