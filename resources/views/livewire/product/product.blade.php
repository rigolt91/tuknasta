<div>
    <div class="grid -mx-2 sm:grid-cols-3">
        @foreach ($products as $product)
            <div class="flex m-2 transition ease-in-out border sm:rounded border-gray-50 hover:shadow-xl hover:-translate-y-1 duration-450">
                <a href="{{ route('product.details', $product->slug) }}" class="w-6/12 text-center bg-white rounded shadow-sm">
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full text-sm text-center sm:rounded-l" alt="{{ $product->name }}">
                </a>

                <div class="w-8/12 m-2">
                    <div class="py-1 font-bold text-gray-800 border-b text-md">{{ $product->name }}</div>
                    <div class="py-1 text-sm text-gray-700 border-b">{{ substr($product->short_description, 0, 50) }}...</div>

                    <div class="flex items-center py-1">
                        <div>
                            <div class="font-bold text-gray-800 text-md">${{ number_format($product->price, 2) }}</div>
                            <div class="text-sm font-bold text-gray-500">${{ number_format($product->previous_price, 2) }}</div>
                        </div>

                        <div class="w-full">
                            <x-button wire:click="$emit('addProductCart', {{ $product }})" wire:loading.attr='disabled' class="disabled:opacity-60 float-right transition duration-300 hover:scale-110">
                                <svg fill="white" class="h-5 text-gray-100 bi bi-cart4" viewBox="0 0 16 16">
                                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                                </svg>
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pt-2 mt-2">{{ $products->links() }}</div>
</div>

