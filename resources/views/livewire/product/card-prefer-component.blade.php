<div>
    <div class="m-2" wire:loading.class="opacity-60">
        <div
            class="flex h-full transition ease-in-out bg-white border border-gray-100 sm:rounded hover:shadow-xl hover:-translate-y-1 duration-450">
            <div class="flex items-center bg-white rounded sm:w-4/12">
                <a href="{{ route('product.details', $slug) }}" wire:loading.class="animation-pulse">
                    <img src="{{ Storage::url($product->image) }}" class="flex items-center justify-center object-cover object-center w-32 h-32 text-xs bg-gray-200 sm:rounded-l" alt="{{ $product->name }}">
                </a>
            </div>

            <div class="relative w-8/12 mx-2 my-1">
                <div class="py-1 text-sm font-bold text-gray-800 border-b sm:py-2 sm:text-md ">
                    {{ $name }}
                </div>

                <div class="h-16 py-0 text-sm text-gray-700 border-b sm:h-auto sm:py-1 sm:block">{{ substr($short_description, 0, 50) }}...</div>

                <div class="py-1">
                    <div class="absolute bottom-0 flex items-center">
                        <div class="font-bold text-gray-800 text-md">${{ number_format($price, 2) }}</div>
                        <div class="ml-2 text-sm font-bold text-gray-500">
                            {{ $previous_price ? '$' . number_format($previous_price, 2) : '' }}</div>
                    </div>

                    <div wire:click='addProductCart({{ $product }})' wire:loading.attr='disabled'
                        class="absolute float-right w-6 h-6 -mt-6 cursor-pointer bottom-1 -right-1 disabled:opacity-60">
                        <svg height="24" width="24" fill="green"
                            class="h-6 -mx-2 duration-150 bi bi-cart4 hover:scale-125" viewBox="0 0 16 16">
                            <path
                                d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
