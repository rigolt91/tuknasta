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
                    <div class="mr-2 text-xs font-bold text-gray-700 uppercase">{{ __('Sort by') }}</div>

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
                        <div wire:loading.class="animate-pulse">
                            <div
                                class="flex h-full transition ease-in-out bg-white border border-gray-100 sm:rounded hover:shadow-xl hover:-translate-y-1 duration-450">
                                <div class="flex items-center bg-white rounded">
                                    <div class="object-cover object-center w-32 h-32 text-xs flex items-center justify-center m-2 bg-gray-200 sm:rounded-l"></div>
                                </div>

                                <div class="w-full m-2">
                                    <div class="py-4 text-sm font-bold text-gray-800 bg-gray-50 sm:text-md "></div>
                                    <div class="py-6 text-sm text-gray-700 bg-gray-50 mt-1 sm:block"></div>
                                    <div class="bg-gray-50 float-right mt-1 py-4 px-12 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @livewire('side-panel.side-panel')
</div>
