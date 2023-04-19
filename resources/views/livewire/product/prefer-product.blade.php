<div>
    <div class="grid grid-cols-1 -mx-2 sm:grid-cols-3">
        @foreach ($products as $product)
        <div class="m-2">
            <div class="flex h-full transition ease-in-out border border-gray-100 sm:rounded hover:shadow-xl hover:-translate-y-1 duration-450">
                <a href="{{ route('product.details', $product->slug) }}" class="bg-white rounded sm:w-4/12"  wire:loading.class="animation-pulse">
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-24 text-sm text-center sm:h-full sm:rounded-l" alt="{{ $product->name }}">
                </a>
                <div class="w-8/12 mx-2 my-1">
                    <div class="py-2 text-sm font-bold text-gray-800 border-b sm:text-md ">
                        {{ $product->name }}
                        <div>
                            <div wire:click="$emit('addProductCart', {{ $product }})" wire:loading.attr='disabled' class="float-right w-6 h-6 -mt-6 cursor-pointer disabled:opacity-60">
                                <svg fill="green" class="h-6 -mx-2 duration-150 bi bi-cart4 hover:scale-125" viewBox="0 0 16 16">
                                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="py-1 text-sm text-gray-700 sm:block">{{ substr($product->short_description, 0, 50) }}...</div>

                    <div class="flex items-center">
                        <div class="font-bold text-gray-800 text-md">${{ number_format($product->price, 2) }}</div>
                        <div class="ml-2 text-sm font-bold text-gray-500">${{ number_format($product->previous_price, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
