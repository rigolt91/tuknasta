<div>
    <div wire:load. class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
            <livewire:slider-component />

            <div class="flex items-center justify-center py-4 mx-4 mb-4 sm:mx-2 border-b">
                <div class="hidden sm:w-1/3 sm:block">
                    <div class="text-2xl font-bold text-gray-700 text-center uppercase">{{ __('Product Categories') }}
                    </div>
                </div>
            </div>

            <livewire:category.card-category-component />

            <div class="mx-4 mb-4 sm:mx-2 pt-8">
                <div class="py-4 mb-8 text-2xl text-center font-bold text-gray-700 border-y uppercase">
                    {{ __('Featured Products') }}
                </div>
                <livewire:product.prefer-product-component>
            </div>
        </div>
    </div>

    <livewire:side-panel.side-panel />
</div>
