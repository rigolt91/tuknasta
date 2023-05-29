<div class="py-6">
    <x-slot name="header">
        <h2 class="font-semibold leading-tight text-gray-800 text-md">
            {{ __('Shopping cart') }}
        </h2>
    </x-slot>

    @if($total_products == 0)
        @include('livewire.cart.empty-cart')
    @else
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
            <div class="sm:flex">
                <div class="w-full">
                    <div class="sm:flex">
                        <div class="mx-4 sm:mx-2 sm:w-9/12">
                            <div class="p-4 mb-4 shadow sm:p-6 sm:rounded-lg">
                                <div class="pb-2 text-lg font-bold text-gray-800 border-b">
                                    {{__('Selected Products')}}
                                </div>

                                @foreach ($carts as $cart)
                                    <div class="flex items-center bg-white overflow-hidden border-b py-2.5 hover:bg-green-50 hover:mx-0.5 hover:cursor-pointer duration-200">
                                        <div class="w-24 h-24 mr-4">
                                            <a href="{{ route('product.details', $cart->product->slug) }}">
                                                <img class="relative w-24 h-24 mr-2 bg-cover border rounded cursor-pointer" src="{{ Storage::url($cart->product->image) }}" />
                                            </a>
                                            <div class="-mt-1 -mr-1 text-center">
                                                <div class="text-gray-700 float-right relative text-sm font-bold -mt-24 -mr-0.5 w-6 h-6 bg-green-600 rounded-full shadow-md">
                                                    <span class="relative text-white">{{ $cart->units }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-2/5 px-0">
                                            <div class="text-sm font-bold text-gray-800">
                                                {{ $cart->product->name }}
                                            </div>

                                            <div class="mr-2 text-sm font-bold text-gray-700 text-md">${{ number_format(($cart->price), 2) }}</div>

                                            <div class="flex pt-2 mr-2 text-sm font-bold text-gray-700 text-md">
                                                <x-button-inline wire:click="$emit('removeProductCart',[{{ $cart->id }}])" wire:loading.attr="disabled" class="flex items-center justify-center h-8 mr-1 text-green-800 hover:text-white">
                                                    <svg fill="currentColor" class="h-5 -m-1 bi bi-dash-square-fill" viewBox="0 0 16 16">
                                                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm2.5 7.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1z"/>
                                                      </svg>
                                                </x-button-inline>

                                                <x-button-inline wire:click="$emit('addProductCart', [{{ $cart->product_id }}])" wire:loading.attr="disabled" class="flex items-center justify-center h-8 mr-1 text-green-800 hover:text-white">
                                                    <svg fill="currentColor" class="h-5 -m-1 bi bi-plus-square-fill" viewBox="0 0 16 16">
                                                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                                                      </svg>
                                                </x-button-inline>
                                            </div>
                                        </div>

                                        <div class="w-1/5">
                                            <span class="text-sm font-bold text-gray-700">{{__('Subtotal')}}: ${{ number_format(($cart->price * $cart->units), 2) }}</span>
                                        </div>

                                        <div class="flex items-center justify-end w-1/5">
                                            <a href="#" wire:click="$emit('clearCart', [{{ $cart->id }}])" wire:loading.attr="disabled" class="ml-2 duration-300 hover:scale-125">
                                                <svg fill="currentColor" class="h-6 text-red-800 bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mx-4 sm:mx-2 sm:w-3/12">
                            @include('livewire.cart.component.total-cost')

                            <div>
                                <x-button-payment route="{{ route('payment.payment') }}">
                                    {{ __('Payment') }}
                                </x-button-payment>

                                @include('livewire.cart.component.btn-empty-cart')

                                <x-button-return route="{{ route('dashboard') }}">
                                    {{ __('Keep buying') }}
                                </x-button-return>
                            </div>

                            @include('livewire.cart.component.politics')
                        </div>
                    </div>

                    <div class="mx-4 mt-4 sm:mx-2 w-12/12">
                        <div class="pb-2 mb-2 text-lg font-bold text-gray-800 border-b">{{__('List of products')}}</div>
                        @livewire('product.product')
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
