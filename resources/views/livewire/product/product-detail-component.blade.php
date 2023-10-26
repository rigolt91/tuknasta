<div class="py-8">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="w-full pr-8 sm:flex sm:pr-0" wire:loading.class='opacity-60'>
            <div class="w-full mx-4 sm:mx-2 sm:w-3/6 sm:rounded">
                <img src="{{ Storage::url($image) }}" style="height:400px; width:400px;"
                    class="object-cover object-center text-xs flex items-center justify-center transition duration-700 ease-in-out bg-gray-200 border border-gray-100 h-[400px] w-[400px] sm:rounded hover:scale-125 hover:shadow-2xl hover:cursor-pointer"
                    alt="{{ $name }}">
            </div>

            <div class="w-full mx-4 sm:mx-2 sm:flex">
                <div class="w-full p-6 border border-gray-100 sm:rounded">
                    <h4 class="mt-2 mb-2 font-semibold text-gray-600 uppercase text-md">{{ __('Product Details') }}</h4>
                    <h2 class="text-2xl font-bold text-gray-700">{{ $name }}</h2>
                    <span class="flex items-center py-3 border-b border-gray-100">
                        @for ($i = 1; $i <= 5; $i++)
                            <x-icon-star wire:click='setStarts({{ $i }})' class="w-6 h-6 cursor-pointer"
                                color="{{ $starts >= $i ? 'green' : 'gray' }}" />
                        @endfor

                        <span class="pr-4 ml-4 border-r border-gray-300">{{ $starts }} {{ __('Starts') }}</span>
                    </span>
                    <div class="py-4 text-gray-700 border-b">
                        {!! $description !!}
                    </div>
                    <div class="pt-4 sm:pb-8">
                        <span
                            class="text-2xl font-bold text-gray-700 sm:float-left">${{ number_format($price, 2) }}</span>
                        <span
                            class="ml-2 text-lg font-bold text-gray-500 sm:float-left">{{ $previous_price != 0 ? '$' . number_format($previous_price, 2) : '' }}</span>
                        <x-button wire:click='addProductCart' wire:loading.attr='disabled'
                            class="flex items-center float-right disabled:opacity-60">
                            <svg fill="white" class="h-5 text-gray-100 bi bi-cart4" viewBox="0 0 16 16">
                                <path
                                    d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                            </svg>
                            <span class="ml-2">{{ __('Add') }}</span>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-2 mx-2 mt-2 sm:mx-0">
            <h2 class="py-2 mb-4 text-lg font-bold text-gray-700 border-b">{{ __('Related Products') }}</h2>

            <div class="flex items-center -my-2">
                @livewire('product.related-product-component', ['product' => $product->id])
            </div>
        </div>

        <div class="p-2 mx-2 mt-4 sm:mx-0">
            <h2 class="pb-2 mb-2 text-xl font-bold text-gray-700 border-b">{{ __('List of products') }}</h2>

            <div class="flex items-center">
                @livewire('product.product-component')
            </div>
        </div>
    </div>
</div>
