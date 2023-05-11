<div>
    <div class="grid sm:grid-cols-3 -mx-2">
        @foreach ($products as $product)
            <div class="sm:rounded flex border border-gray-50 hover:shadow-xl hover:-translate-y-1 m-2  transition duration-450 ease-in-out">
                <a href="{{ route('product.details', $product->slug) }}" class="bg-white w-6/12 text-center shadow-sm rounded">
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full sm:rounded-l text-sm text-center" alt="{{ $product->name }}">
                </a>

                <div class="m-2 w-8/12">
                    <div class="text-md text-gray-800 font-bold border-b py-1">{{ $product->name }}</div>
                    <div class="text-sm text-gray-700 border-b py-1">{{ substr($product->short_description, 0, 50) }}...</div>

                    <div class="flex items-center py-1">
                        <div>
                            <div class="text-md text-gray-800 font-bold">${{ number_format($product->price, 2) }}</div>
                            <div class="text-sm text-gray-500 font-bold">${{ number_format($product->previous_price, 2) }}</div>
                        </div>

                        <div class="w-full">
                            <x-button wire:click="$emit('addProductCart', {{ $product }})" wire:loading.attr='disabled' class="float-right hover:scale-110 transition duration-300">
                                <svg fill="white" class="bi bi-cart4 text-gray-100 h-5 -mx-2" viewBox="0 0 16 16">
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

