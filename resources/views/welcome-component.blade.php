<div>
    <div wire:load. >
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
            <div>
                <livewire:slider-component />
            </div>

            <div class="mx-4 my-12 sm:mx-2">
                <div class="flex items-end justify-between gap-4 pb-6 mb-6 border-b border-gray-200">
                    <div>
                        <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-indigo-700 before:block before:h-0.5 before:w-4 before:bg-current">
                            {{ __('Catalog') }}
                        </span>
                        <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 font-display sm:text-3xl">
                            {{ __('Shop by category') }}
                        </h2>
                    </div>
                </div>
                <livewire:category.card-category-component />
            </div>

            @if($recomendedProduct > 0)
                <div class="mx-4 my-12 sm:mx-2">
                    <div class="flex items-end justify-between gap-4 pb-6 mb-6 border-b border-gray-200">
                        <div>
                            <span class="inline-flex items-center gap-2 text-xs font-semibold tracking-widest uppercase text-indigo-700 before:block before:h-0.5 before:w-4 before:bg-current">
                                {{ __('Multi-vendor') }}
                            </span>
                            <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 font-display sm:text-3xl">
                                {{ __('Featured Products') }}
                            </h2>
                        </div>
                    </div>
                    <livewire:product.prefer-product-component>
                </div>
            @endif
        </div>
    </div>
    <livewire:side-panel.side-panel />
</div>
