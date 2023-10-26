<div>
    <x-dropdown align="right" width="64">
        <x-slot name="trigger">
            <button
                class="inline-flex items-center px-2 py-1 mr-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                <div class="relative">
                    <div class="absolute left-5">
                        <p
                            class="flex h-6 w-6 items-center justify-center rounded bg-green-700 p-2.5 text-md text-gray-100">
                            <span wire:loading.class="hidden">{{ $total_products }}</span>

                            <svg wire:loading.class.remove="hidden" fill="white" class="hidden -mx-2" width="24" height="24" viewBox="0 0 24 24">
                                <g>
                                    <circle cx="3" cy="12" r="2" />
                                    <circle cx="21" cy="12" r="2" />
                                    <circle cx="12" cy="21" r="2" />
                                    <circle cx="12" cy="3" r="2" />
                                    <circle cx="5.64" cy="5.64" r="2" />
                                    <circle cx="18.36" cy="18.36" r="2" />
                                    <circle cx="5.64" cy="18.36" r="2" />
                                    <circle cx="18.36" cy="5.64" r="2" />
                                    <animateTransform attributeName="transform" type="rotate" dur="1.5s" values="0 12 12;360 12 12" repeatCount="indefinite" />
                                </g>
                            </svg>
                        </p>
                    </div>
                    <svg height="30" width="30" class="mt-2 bi bi-cart3" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                </div>
            </button>
        </x-slot>
        <x-slot name="content">
            @if ($total_products > 0)
                @foreach ($carts as $cart)
                    <x-dropdown-link :href="route('product.details', $cart->product->slug)" class="flex hover:bg-white focus:bg-white">
                        <div class="flex items-center -my-2 overflow-hidden bg-white border-b">
                            <img class="flex items-center justify-center w-10 h-10 mx-2 text-xs text-center bg-gray-200 bg-cover border"
                                src="{{ Storage::url($cart->product->image) }}" alt="img" />
                            <div class="w-3/4 px-0">
                                <div class="text-sm font-bold text-gray-800">
                                    <div>{{ $cart->product->name }} ({{ $cart->units }})</div>
                                </div>
                                <div class="flex justify-between mt-0">
                                    <div class="text-sm text-gray-700">{{ __('Price') }}:</div>
                                    <div class="mr-2 text-sm font-bold text-gray-700">
                                        ${{ number_format($cart->price * $cart->units, 2) }}</div>
                                </div>
                            </div>
                            <a href="#" wire:click='clearCart({{ $cart->id }})' class="ml-2">
                                <svg fill="currentColor" class="h-5 my-2 mr-3 text-red-800 bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>
                            </a>
                        </div>
                    </x-dropdown-link>
                @endforeach
                <div class="flex justify-center px-6 py-1 mt-2 overflow-hidden text-sm uppercase font-bold text-gray-700">
                    {{ __('Total Cost') }}: ${{ number_format($total_amount, 2) }}
                </div>
                <div className="flex justify-center">
                    <a href="{{ route('cart.details') }}"
                        class="flex justify-center -mb-1 rounded-b-md py-1.5 font-bold text-gray-100 uppercase text-sm bg-green-800 hover:bg-green-700 focus:bg-green-700">
                        {{ __('Go To Cart') }}
                    </a>
                </div>
            @else
                <div class="flex justify-center px-4 py-2 text-gray-700">
                    {{ __('Add products to cart') }}
                </div>
            @endif
        </x-slot>
    </x-dropdown>
</div>
