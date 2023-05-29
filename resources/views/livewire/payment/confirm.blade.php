<div class="my-6">
    <x-slot name="header">
        <h2 class="font-semibold leading-tight text-gray-800 text-md">
            {{ __('Confirm Payment') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-6">
        <div class="mx-4 sm:mx-2">
            <div class="mb-4">
                @include('livewire.payment.steps.steps-bars-payment')
            </div>
            <form wire:submit.prevent="paymentConfirm" method="post">
                @csrf
                <div class="sm:flex">
                    <div class="sm:mx-2 sm:w-9/12">
                        <div class="px-4 py-6 mb-4 shadow sm:px-6 sm:rounded-lg">
                            <x-card-header>
                                <span class="font-bold text-gray-600">{{__('Card Information')}}</span>
                            </x-card-header>
                            <x-card-body>
                                <div class="mt-4 sm:flex">
                                    <div class="w-full mb-4 sm:mr-2">
                                        <div class="relative">
                                            <x-label for="number" :value="__('Card number')" />
                                            <x-input wire:model.lazy='number' type="text" class="block w-full mt-1" :value="old('number', $number)" placeholder="{{__('Card number')}}" autocomplete="number" />
                                        </div>
                                        <x-input-error class="mt-2" for="number" />
                                    </div>

                                    <div class="w-full mb-4 sm:ml-2">
                                        <div class="relative">
                                            <x-label for="cvv" :value="__('CVV')" />
                                            <x-input wire:model.lazy='cvv' type="text" min="1" class="block w-full mt-1" :value="old('cvv', $cvv)" placeholder="{{__('Security code')}}" autocomplete="cvv" />
                                        </div>
                                        <x-input-error class="mt-2" for="cvv" />
                                    </div>
                                </div>

                                <div class="sm:flex">
                                    <div class="w-full mb-4 sm:mr-2">
                                        <div class="relative">
                                            <x-label for="expiryMonth" :value="__('Expiry month')" />
                                            <x-input wire:model.lazy='expiryMonth' type="text" class="block w-full mt-1" :value="old('expiryMonth', $expiryMonth)" placeholder="{{__('Expiry month')}}" autocomplete="expiryMonth" />
                                        </div>
                                        <x-input-error class="mt-2" for="expiryMonth" />
                                    </div>

                                    <div class="w-full mb-4 sm:ml-2">
                                        <div class="relative">
                                            <x-label for="expiryYear" :value="__('Expiration year')" />
                                            <x-input wire:model.lazy='expiryYear' type="text" class="block w-full mt-1" :value="old('expiryYear', $expiryYear)" placeholder="{{__('Expiration year')}}" autocomplete="expiryYear" />
                                        </div>
                                        <x-input-error class="mt-2" for="expiryYear" />
                                    </div>
                                </div>
                            </x-card-body>
                        </div>

                        <div class="px-4 py-6 mb-4 shadow sm:px-6 sm:rounded-lg">
                            <div class="items-center pt-1 pb-3 border-b">
                                <span class="font-semibold text-gray-600 text-md ">{{__('Receiver information')}}</span>

                                <x-button-inline type="button" wire:click="$emit('openModal', 'profile.my-contact.my-contact')" class="items-center float-right w-8 h-8 text-green-800 hover:text-white">
                                    <svg fill="currentColor" class="h-6 -mx-3 bi bi-plus-square" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                </x-button-inline>
                            </div>

                            <div class="mt-2">
                                @include('livewire.payment.component.contact')
                            </div>
                        </div>
                    </div>

                    <div class="sm:mx-2 sm:w-3/12">

                        <x-button type="submit" wire:loading.attr="disabled" class="w-full mb-4 rounded-none disabled:opacity-60 sm:rounded">
                            <svg fill="currentColor" class="h-5 mr-2 bi bi-credit-card-2-back-fill" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5H0V4zm11.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zM0 11v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1H0z"/>
                            </svg>
                            {{ __('Payment') }}
                            <x-icon-spin wire:loading wire:target="paymentConfirm" class="ml-1" />
                        </x-button>

                        <div class="px-4 py-4 mb-4 shadow sm:rounded-lg sm:px-6">
                            <x-card-header class="font-bold">{{ __('Purshase Details') }}</x-card-header>

                            <x-card-body>
                                <div class="mb-2 text-gray-700 border-b">
                                    <span>{{__('Number of order')}}</span>
                                    <div class="float-right font-semibold">{{ $order_number }}</div>
                                </div>
                                <div class="text-gray-700">
                                    <span>{{__('Delivery method')}}</span>
                                    <div class="float-right font-semibold">{{ $delivery_method->name }}</div>
                                </div>
                            </x-card-body>
                        </div>

                        <div class="px-4 py-4 mb-4 shadow sm:rounded-lg sm:px-6">
                            @include('livewire.payment.component.products')
                        </div>

                        @include('livewire.cart.component.total-cost')

                        @include('livewire.cart.component.politics')

                        <div class="-mt-4">
                            <x-button-return route="{{ route('payment.delivery') }}">
                                {{ __('Delivery') }}
                            </x-button-return>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
