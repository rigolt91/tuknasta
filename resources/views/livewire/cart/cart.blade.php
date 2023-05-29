<div>
    <x-dropdown align="right" width="64">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-2 py-1 mr-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                <div class="relative">
                    <div class="absolute left-3">
                        <p class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 p-2.5 text-md text-gray-900">
                            <span wire:loading.class="hidden">{{ $total_products }}</span>

                            <svg wire:loading.class.remove="hidden" fill="green" class="hidden -mx-2" width="24" height="24" viewBox="0 0 24 24">
                                <g>
                                    <circle cx="3" cy="12" r="2"/><circle cx="21" cy="12" r="2"/><circle cx="12" cy="21" r="2"/><circle cx="12" cy="3" r="2"/><circle cx="5.64" cy="5.64" r="2"/><circle cx="18.36" cy="18.36" r="2"/><circle cx="5.64" cy="18.36" r="2"/><circle cx="18.36" cy="5.64" r="2"/><animateTransform attributeName="transform" type="rotate" dur="1.5s" values="0 12 12;360 12 12" repeatCount="indefinite"/>
                                </g>
                            </svg>
                        </p>
                    </div>
                    <svg fill="white" class="bi bi-cart3 h-6 mt-2" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </div>
            </button>
        </x-slot>
        <x-slot name="content">
            @if ($total_products > 0)
                @foreach ($carts as $cart)
                <x-dropdown-link :href="route('product.details', $cart->product->slug)" class="flex hover:bg-white focus:bg-white">
                    <div class="flex items-center bg-white overflow-hidden border-b -my-2">
                        <img class="w-10 h-10 bg-cover mx-2 border" src="{{ Storage::url($cart->product->image) }}" />
                        <div class="w-3/4 px-0">
                            <div class="text-gray-800 font-bold text-sm">
                                <div>{{ $cart->product->name }} ({{ $cart->units }})</div>
                            </div>
                            <div class="flex justify-between mt-0">
                                <div class="text-gray-700 text-sm">{{ __('Price') }}:</div>
                                <div class="text-gray-700 font-bold text-sm mr-2">${{ number_format(($cart->price * $cart->units), 2) }}</div>
                            </div>
                        </div>
                        <a href="#" wire:click='clearCart({{ $cart->id }})' class="ml-2">
                            <svg fill="currentColor" class="bi bi-trash3 h-5 mr-3 my-2 text-red-800" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                            </svg>
                        </a>
                    </div>
                </x-dropdown-link>
                @endforeach
            @else
                <div class="py-2 px-4 text-gray-700 flex justify-center border-b">
                    {{ __('Add products to cart') }}
                </div>
            @endif
            <div class="flex text-gray-700 justify-center font-bold overflow-hidden border-b-2 mt-2 px-6 py-1">
                {{__('Total Cost')}}: ${{ number_format($total_amount, 2) }}
            </div>
            <div className="flex justify-center px-2 py-2 -mb-0.2 bg-green-800 text-white font-bold uppercase">
                <a href="{{ route('cart.details') }}" class="flex py-2 mx-2 mt-2 bg-green-800 rounded text-gray-100 font-bold justify-center hover:bg-green-700 focus:bg-green-700">
                    {{__('Go To Cart')}}
                </a>
            </div>
        </x-slot>
    </x-dropdown>
</div>
