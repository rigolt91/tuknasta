<div>
    <div wire:load. class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
            <div class="flex py-2 mx-4 mb-4 sm:mx-2 border-y">
                <div class="sm:w-1/3">
                    <x-button-inline wire:click="filter" wire:loading.attr='disabled' class="mr-2 disabled:opacity-60">
                        <svg width="16" height="16" fill="currentColor" class="mr-1 bi bi-filter"
                            viewBox="0 0 16 16">
                            <path
                                d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                        </svg>
                        {{ __('Filter') }}
                    </x-button-inline>
                </div>

                <div class="flex items-center justify-center w-full sm:w-2/3 sm:justify-end">
                    <div class="text-xs text-gray-700 font-bold uppercase mr-2">{{ __('Sort by') }}</div>

                    <x-button-inline wire:click="orderProducts('category_id')" wire:loading.attr='disabled'
                        class="disabled:opacity-60">
                        {{ __('Category') }}
                    </x-button-inline>

                    <x-button-inline wire:click="orderProducts('price')" wire:loading.attr='disabled'
                        class="ml-2 disabled:opacity-60">
                        {{ __('Price') }}
                    </x-button-inline>
                </div>
            </div>

            <div>
                @if ($products->count() > 0)
                    <div class="grid sm:grid-cols-3 lg:grid-cols-5" wire:loading.class='opacity-60'>
                        @foreach ($products as $product)
                            <livewire:product.card-component :product="$product" :key="$product->id">
                        @endforeach
                    </div>
                @else
                    <div class="mx-2">
                        <x-card>
                            <x-card-body>
                                <div class="text-gray-700">{{ __('There are no products available at the moment.') }}
                                </div>
                            </x-card-body>
                        </x-card>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @livewire('side-panel.side-panel')
</div>
