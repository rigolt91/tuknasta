<div>
    <div wire:load. class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
            <livewire:slider-component />

            <div class="mx-4 mb-4 sm:mx-2">
                <div class="py-4 mb-8 text-2xl font-bold text-center text-gray-700 uppercase border-y">
                    {{ __('Product Categories') }}
                </div>
                <livewire:category.card-category-component />
            </div>

            @if($recomendedProduct > 0)
                <div class="pt-8 mx-4 mb-4 sm:mx-2">
                    <div class="py-4 mb-8 text-2xl font-bold text-center text-gray-700 uppercase border-y">
                        {{ __('Featured Products') }}
                    </div>
                    <livewire:product.prefer-product-component>
                </div>
            @endif
        </div>
    </div>
    <livewire:side-panel.side-panel />
</div>
