<div class="m-2">
    <div wire:loading.class='opacity-60' class="w-full p-6 transition ease-in-out border border-gray-100 sm:rounded-lg hover:shadow-2xl hover:-translate-y-1 duration-400">
        <x-card-header class="-mx-6 -mt-6">
            <a href="{{ route('product.details', $slug) }}">
                <img class="w-full h-full sm:rounded-t-md" src="{{ Storage::url($image) }}" />
            </a>
        </x-card-header>

        <x-card-body>
            <div class="sm:h-16">
                <h6 class="font-bold text-gray-900 text-md">{{ $name }}</h6>
                <h5 class="text-sm text-gray-800">{{ substr($short_description, 0, 50) }}...</h5>
            </div>
        </x-card-body>

        <x-card-footer class="-mx-6">
            <div class="flex items-center h-8 mx-2 mt-2 -mb-4">
                <div class="font-bold">
                    <span class="text-lg">${{ number_format($price, 2) }}</span>
                    <p class="-mt-2 text-sm text-gray-500">{{ !empty($previous_price) ? '$'.number_format($previous_price, 2) : ''}}</p>
                </div>

                <div class="w-full">
                    <x-button wire:click="$emit('addProductCart', {{ $product }})" wire:loading.attr='disabled' class="float-right duration-150 disabled:opacity-25 hover:scale-110">
                        <svg fill="white" class="h-5 -mx-2 text-gray-100 bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                        </svg>
                    </x-button>
                </div>
            </div>
        </x-card-footer>
    </div>
</div>
